<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add columns to documents table
        Schema::table('documents', function (Blueprint $table) {
            if (!Schema::hasColumn('documents', 'court_type')) {
                $table->string('court_type', 50)->nullable()->default('NEEDS_CLASSIFICATION')->after('master_document_id')->index();
            }
            if (!Schema::hasColumn('documents', 'pemohon')) {
                $table->text('pemohon')->nullable()->after('pihak_eksternal');
            }
            if (!Schema::hasColumn('documents', 'termohon')) {
                $table->text('termohon')->nullable()->after('pemohon');
            }
            if (!Schema::hasColumn('documents', 'pokok_perkara')) {
                $table->text('pokok_perkara')->nullable()->after('termohon');
            }
            if (!Schema::hasColumn('documents', 'amar_putusan')) {
                $table->text('amar_putusan')->nullable()->after('pokok_perkara');
            }
        });

        // 2. Add columns to documents_lang table
        Schema::table('documents_lang', function (Blueprint $table) {
            if (!Schema::hasColumn('documents_lang', 'pemohon')) {
                $table->text('pemohon')->nullable()->after('subjek');
            }
            if (!Schema::hasColumn('documents_lang', 'termohon')) {
                $table->text('termohon')->nullable()->after('pemohon');
            }
            if (!Schema::hasColumn('documents_lang', 'pokok_perkara')) {
                $table->text('pokok_perkara')->nullable()->after('termohon');
            }
            if (!Schema::hasColumn('documents_lang', 'amar_putusan')) {
                $table->text('amar_putusan')->nullable()->after('pokok_perkara');
            }
        });

        // 3. Handle existing putusan documents (master_document_id = 5)
        $existingPutusan = DB::table('documents')->where('master_document_id', 5)->get();
        foreach ($existingPutusan as $doc) {
            $langId = DB::table('documents_lang')->where('base_id', $doc->id)->where('lang', 'id')->first();
            $jenis = strtolower($langId->jenis_peradilan ?? '');
            $singkatan = strtoupper(trim($langId->singkatan_peradilan ?? ''));
            
            $court = 'NEEDS_CLASSIFICATION';
            if (str_contains($jenis, 'agung') || $singkatan === 'MA') {
                $court = 'MA';
            } elseif (str_contains($jenis, 'konstitusi') || $singkatan === 'MK') {
                $court = 'MK';
            }

            DB::table('documents')->where('id', $doc->id)->update([
                'court_type' => $court
            ]);
        }

        // 4. Update Parent Menu 11 labels to "Dokumen Hukum"
        DB::table('menus_lang')->where('base_id', 11)->where('lang', 'id')->update([
            'label' => 'Dokumen Hukum',
        ]);
        DB::table('menus_lang')->where('base_id', 11)->where('lang', 'en')->update([
            'label' => 'Legal Documents',
        ]);

        // 5. Update sort order of items under Menu 11
        // Sort 1: Peraturan Hukum (ID 12)
        DB::table('menus')->where('id', 12)->update(['sort_id' => 1]);
        DB::table('menus_lang')->where('base_id', 12)->where('lang', 'id')->update(['label' => 'Peraturan Hukum']);

        // Sort 2: Putusan Hukum (ID 16)
        DB::table('menus')->where('id', 16)->update(['sort_id' => 2]);
        DB::table('menus_lang')->where('base_id', 16)->where('lang', 'id')->update(['label' => 'Putusan Hukum']);
        DB::table('menus_lang')->where('base_id', 16)->where('lang', 'en')->update(['label' => 'Court Decisions']);

        // Sort 3: Monografi Hukum (ID 17)
        DB::table('menus')->where('id', 17)->update(['sort_id' => 3]);
        DB::table('menus_lang')->where('base_id', 17)->where('lang', 'id')->update(['label' => 'Monografi Hukum']);

        // Sort 4: Naskah Kerja Sama (ID 18)
        DB::table('menus')->where('id', 18)->update(['sort_id' => 4]);

        // 6. Create submenus under Putusan Hukum (parent_id = 16)
        // Check if MA submenu exists
        $maMenu = DB::table('menus')->where('parent_id', 16)->where('sort_id', 1)->first();
        if (!$maMenu) {
            $maId = DB::table('menus')->insertGetId([
                'parent_id' => 16,
                'type' => 'url',
                'sort_id' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('menus_lang')->insert([
                [
                    'base_id' => $maId,
                    'lang' => 'id',
                    'label' => 'Putusan Mahkamah Agung (MA)',
                    'url' => '/putusan-hukum/mahkamah-agung',
                ],
                [
                    'base_id' => $maId,
                    'lang' => 'en',
                    'label' => 'Supreme Court Decisions (MA)',
                    'url' => '/putusan-hukum/mahkamah-agung',
                ],
            ]);
        } else {
            DB::table('menus')->where('id', $maMenu->id)->update([
                'type' => 'url',
                'is_active' => 1,
                'updated_at' => now(),
            ]);
            DB::table('menus_lang')->where('base_id', $maMenu->id)->where('lang', 'id')->update([
                'label' => 'Putusan Mahkamah Agung (MA)',
                'url' => '/putusan-hukum/mahkamah-agung',
            ]);
            DB::table('menus_lang')->where('base_id', $maMenu->id)->where('lang', 'en')->update([
                'label' => 'Supreme Court Decisions (MA)',
                'url' => '/putusan-hukum/mahkamah-agung',
            ]);
        }

        // Check if MK submenu exists
        $mkMenu = DB::table('menus')->where('parent_id', 16)->where('sort_id', 2)->first();
        if (!$mkMenu) {
            $mkId = DB::table('menus')->insertGetId([
                'parent_id' => 16,
                'type' => 'url',
                'sort_id' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('menus_lang')->insert([
                [
                    'base_id' => $mkId,
                    'lang' => 'id',
                    'label' => 'Putusan Mahkamah Konstitusi (MK)',
                    'url' => '/putusan-hukum/mahkamah-konstitusi',
                ],
                [
                    'base_id' => $mkId,
                    'lang' => 'en',
                    'label' => 'Constitutional Court Decisions (MK)',
                    'url' => '/putusan-hukum/mahkamah-konstitusi',
                ],
            ]);
        } else {
            DB::table('menus')->where('id', $mkMenu->id)->update([
                'type' => 'url',
                'is_active' => 1,
                'updated_at' => now(),
            ]);
            DB::table('menus_lang')->where('base_id', $mkMenu->id)->where('lang', 'id')->update([
                'label' => 'Putusan Mahkamah Konstitusi (MK)',
                'url' => '/putusan-hukum/mahkamah-konstitusi',
            ]);
            DB::table('menus_lang')->where('base_id', $mkMenu->id)->where('lang', 'en')->update([
                'label' => 'Constitutional Court Decisions (MK)',
                'url' => '/putusan-hukum/mahkamah-konstitusi',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete submenus of Menu 16
        $sub16Ids = DB::table('menus')->where('parent_id', 16)->pluck('id');
        DB::table('menus_lang')->whereIn('base_id', $sub16Ids)->delete();
        DB::table('menus')->where('parent_id', 16)->delete();

        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['court_type', 'pemohon', 'termohon', 'pokok_perkara', 'amar_putusan']);
        });

        Schema::table('documents_lang', function (Blueprint $table) {
            $table->dropColumn(['pemohon', 'termohon', 'pokok_perkara', 'amar_putusan']);
        });
    }
};

