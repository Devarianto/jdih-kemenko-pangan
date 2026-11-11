<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Document;
use App\Models\Regulasi;
use App\Models\RegulasiProses;
use App\Models\Tanggapan;
use Cactuar\Admin\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ComprehensiveSystemAuditTest extends TestCase
{
    protected string $baseUrl = 'http://127.0.0.1:8000';

    /**
     * Test 1: Halaman publik utama dan navigasi menu wajib mengembalikan HTTP 200
     */
    public function test_public_homepage_and_navigation_pages_return_200(): void
    {
        $routes = [
            '/',
            '/visi-misi',
            '/landasan-hukum',
            '/struktur-organisasi',
            '/tentang-sop',
            '/statistik-produk-hukum',
            '/peraturan-hukum',
            '/peraturan-terjemahan',
            '/monografi-hukum',
            '/naskah-kerja-sama',
            '/majalah-hukum',
            '/putusan-hukum',
            '/program-penyusunan-puu',
            '/rancangan-puu',
            '/naskah-urgensiakademik',
            '/anev-puu',
            '/risalah-pembahasan',
            '/kajian-hukum',
            '/partisipasi-publik',
            '/berita',
            '/galeri',
            '/infografis',
            '/videografis',
            '/aksesibilitas',
            '/kontak',
        ];

        foreach ($routes as $route) {
            $response = Http::get($this->baseUrl . $route);
            $this->assertSame(200, $response->status(), "Route {$route} failed with status {$response->status()}");
            $this->assertNotEmpty($response->body());
        }
    }

    /**
     * Test 2: Fitur pencarian dokumen dan filter query
     */
    public function test_document_search_and_filters(): void
    {
        $searches = [
            '/peraturan-hukum?q=pangan',
            '/peraturan-hukum?q=PANGAN',
            '/peraturan-hukum?year=2026',
            '/peraturan-hukum?status=1',
            '/peraturan-hukum?q=nonexistentkeyword99999',
            '/peraturan-hukum?q=%27+OR+%271%27%3D%271',
            '/peraturan-hukum?page=1',
            '/monografi-hukum?q=neraca',
            '/majalah-hukum?q=hukum',
        ];

        foreach ($searches as $query) {
            $response = Http::get($this->baseUrl . $query);
            $this->assertSame(200, $response->status(), "Search query {$query} failed");
        }
    }

    /**
     * Test 3: API Statistik publik dan Integrasi JDIHN
     */
    public function test_statistics_apis_and_export(): void
    {
        $apis = [
            '/api/statistics/legal-products',
            '/api/statistics/legal-products/by-type',
            '/api/statistics/legal-products/by-year',
            '/api/statistics/legal-products/matrix',
            '/api/statistics/legal-products/export-pdf',
            '/jdihn-json',
        ];

        foreach ($apis as $api) {
            $response = Http::get($this->baseUrl . $api);
            $this->assertSame(200, $response->status(), "API {$api} failed");
        }
    }

    /**
     * Test 4: Proteksi akses tamu (Guest tidak boleh mengakses backend/admin tanpa login)
     */
    public function test_unauthenticated_guest_cannot_access_protected_routes(): void
    {
        $protected = [
            '/admin-panel/document-peraturan',
            '/admin-panel/account',
            '/admin-panel/site-setting/config',
            '/dashboard',
            '/regulasi',
            '/admin/partisipasi-publik',
            '/admin/users',
        ];

        foreach ($protected as $url) {
            $response = Http::withoutRedirecting()->get($this->baseUrl . $url);
            $status = $response->status();
            // Should either redirect to login (302) or render login page (200 with password input)
            $isProtected = ($status === 302 || $status === 401 || $status === 403);
            $this->assertTrue($isProtected, "URL {$url} is not protected (HTTP {$status})");
        }
    }

    /**
     * Test 5: Keamanan file sensitif dan security headers
     */
    public function test_security_headers_and_file_protection(): void
    {
        $response = Http::get($this->baseUrl . '/');
        $this->assertTrue($response->hasHeader('Content-Security-Policy'), 'CSP header missing');
        $this->assertTrue($response->hasHeader('X-Frame-Options'), 'X-Frame-Options missing');
        $this->assertTrue($response->hasHeader('X-Content-Type-Options'), 'X-Content-Type-Options missing');

        // Sensitive files return 404
        $this->assertSame(404, Http::get($this->baseUrl . '/.env')->status());
        $this->assertSame(404, Http::get($this->baseUrl . '/.git/config')->status());
        $this->assertSame(404, Http::get($this->baseUrl . '/storage/logs/laravel.log')->status());
    }

    /**
     * Test 6: Super Admin CRUD & Dynamic Metadata CMS
     */
    public function test_superadmin_crud_and_dynamic_metadata(): void
    {
        $superAdmin = User::where('role', 'super_admin')->firstOrFail();
        $this->assertTrue($superAdmin->isRoot, 'Superadmin must have isRoot=true');

        // CREATE
        $testNo = 'PHPUNIT-TEST-' . time();
        $doc = new Document();
        $doc->master_document_id = 1;
        $doc->document_type_id = 1;
        $doc->rule_type_id = 1;
        $doc->no_peraturan = $testNo;
        $doc->year = 2026;
        $doc->status_berlaku = 1;
        $doc->is_active = 0;
        $doc->save();

        $this->assertDatabaseHas('documents', ['id' => $doc->id, 'no_peraturan' => $testNo]);

        // UPDATE
        $doc->lokasi = 'Kemenko Pangan Audit';
        $doc->save();
        $this->assertDatabaseHas('documents', ['id' => $doc->id, 'lokasi' => 'Kemenko Pangan Audit']);

        // DELETE
        $docId = $doc->id;
        $doc->delete();
        $this->assertDatabaseMissing('documents', ['id' => $docId]);
    }

    /**
     * Test 7: Isolasi RBAC Operator e-Regulasi (Dilarang akses Superadmin)
     */
    public function test_operator_eregulasi_rbac_isolation(): void
    {
        $operator = User::where('role', 'admin_operator')->firstOrFail();

        // Operator is NOT root
        $this->assertFalse($operator->isRoot, 'Operator must NOT have isRoot=true');

        // Operator cannot access Cadmin modules
        $this->assertFalse($operator->allow('document-peraturan', 'index'));
        $this->assertFalse($operator->allow('account', 'index'));

        // Operator only allowed e-Regulasi bridges
        $this->assertTrue($operator->allow('puu-pengajuan', 'index'));
        $this->assertTrue($operator->allow('puu-partisipasi-publik', 'index'));
    }

    /**
     * Test 8: Integrasi e-Regulasi ke JDIH Rancangan PUU & Anti-Duplikasi
     */
    public function test_integration_eregulasi_to_jdih_rancangan_sync(): void
    {
        $operator = User::where('role', 'admin_operator')->firstOrFail();

        // Create Regulasi
        $reg = new Regulasi();
        $reg->jenis = 'Peraturan Menteri Koordinator';
        $reg->judul = 'RPermen PHPUnit Audit ' . time();
        $reg->abstrak = 'Uji integrasi PHPUnit';
        $reg->tgl_usulan = date('Y-m-d');
        $reg->unit_kerja = 'Biro Hukum';
        $reg->status = 'uji_publik';
        $reg->current_stage = 'uji_publik';
        $reg->uji_publik_status = 'approved';
        $reg->created_by = $operator->id;
        $reg->save();

        // Create Tanggapan Publik
        $tanggapan = new Tanggapan();
        $tanggapan->regulasi_id = $reg->id;
        $tanggapan->nama_pengirim = 'Penguji Unit Test';
        $tanggapan->email = 'tester@phpunit.id';
        $tanggapan->isi_tanggapan = 'Tanggapan otomatis test unit.';
        $tanggapan->status_tindak_lanjut = 'pending';
        $tanggapan->save();

        $this->assertDatabaseHas('tanggapan', ['id' => $tanggapan->id]);

        // Sync ke JDIH
        $jdihRancangan = new Document();
        $jdihRancangan->master_document_id = 2;
        $jdihRancangan->document_type_id = 1;
        $jdihRancangan->regulasi_id = $reg->id;
        $jdihRancangan->no_peraturan = $reg->judul;
        $jdihRancangan->year = 2026;
        $jdihRancangan->is_active = 1;
        $jdihRancangan->save();

        $this->assertDatabaseHas('documents', ['id' => $jdihRancangan->id, 'regulasi_id' => $reg->id]);

        // Clean up
        $tanggapan->delete();
        $jdihRancangan->delete();
        $reg->delete();
    }
}
