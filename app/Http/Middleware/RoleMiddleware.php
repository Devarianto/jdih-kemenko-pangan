<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Terima satu atau lebih role, dipisah koma di route, contoh:
     * 'role:admin_operator,super_admin'
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->guest(url(config('cadmin.cadmin.admin-url', 'admin-panel') . '/guest/login'));
        }

        $user = auth()->user();
        if (isset($user->is_enable) && $user->is_enable !== 'Yes') {
            return redirect(url(config('cadmin.cadmin.admin-url', 'admin-panel') . '/logout'));
        }

        $userRole = $user->role ?: 'super_admin';
        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki hak akses untuk fitur ini.');
        }

        // Share Cactuar Admin Panel navigation & layout variables so unified sidebar works seamlessly
        $this->shareCactuarAdminContext($user, $request);

        return $next($request);
    }

    /**
     * Build and share Cactuar Admin Panel sidebar menu, website config, and baseTitle
     */
    protected function shareCactuarAdminContext($user, Request $request): void
    {
        if (!defined('ADMIN')) {
            define('ADMIN', config('cadmin.cadmin.admin-url', 'admin-panel'));
        }
        if (!defined('inAdmin')) {
            define('inAdmin', 'yes i am');
        }

        $conf = [];
        $root = config('cadmin.menu-root');
        if ($user->isRoot && !empty($root)) {
            $conf['root'] = ['label' => 'Superadmin', 'fa' => 'user', 'parent' => null, 'child' => []];
            foreach ($root as $k => $v) {
                $v['parent'] = 'root';
                $conf[$k] = $v;
            }
        }

        foreach ((array) config('cadmin.menu') as $k => $v) {
            $conf[$k] = $v;
        }

        $menu = [];
        foreach ($conf as $k => $v) {
            if (\Arr::get($v, 'parent') == null) {
                $menu[$k] = $v;
            }
        }

        foreach ($conf as $k => $v) {
            $parentID = \Arr::get($v, 'parent');
            if (!$parentID || !array_key_exists($parentID, $menu)) {
                $menu[$k] = $v;
                continue;
            }
            if (!\Arr::get($menu[$parentID], 'child')) {
                $menu[$parentID]['child'] = [];
            }
            $menu[$parentID]['child'][$k] = $v;
        }

        $module = $menu;
        if (array_key_exists('root', $module)) {
            unset($module['root']);
        }

        // Filter by user permission
        foreach ($menu as $k => $v) {
            $forbidden = true;
            if (is_array(\Arr::get($v, 'child'))) {
                foreach (\Arr::get($v, 'child') as $kk => $vv) {
                    $act = \Arr::get($vv, 'default-action', 'index');
                    if ($user->allow($kk, $act)) {
                        $forbidden = false;
                    } else {
                        unset($menu[$k]['child'][$kk]);
                    }
                }
            } else {
                $act = \Arr::get($v, 'default-action', 'index');
                if ($user->allow($k, $act)) {
                    $forbidden = false;
                }
            }
            if ($forbidden) {
                unset($menu[$k]);
            }
        }

        $activeModule = $request->is('admin/partisipasi-publik*') ? 'puu-partisipasi-publik' : 'puu-pengajuan';
        $baseTitle = $activeModule === 'puu-partisipasi-publik'
            ? '<label style="color:#aaa;font-weight:100;">Dokumen Pembentukan PUU / </label> Partisipasi Publik'
            : '<label style="color:#aaa;font-weight:100;">Dokumen Pembentukan PUU / </label> Pengajuan PUU';

        $website = \Cactuar\Admin\Models\Conf::initial('site-setting');

        view()->share(compact('menu', 'module', 'baseTitle', 'website', 'activeModule'));
    }
}
