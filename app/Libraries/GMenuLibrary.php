<?php

namespace App\Libraries;

use App\Menu;
use Illuminate\Http\Request;

class GMenuLibrary
{
    public function __construct()
    {
        $this->admin = str_replace('/','',\Request::route()->getPrefix());
    }

    private function getMenus()
    {
        $menus = array();
        $rows = Menu::where('menu_active', '1')->orderBy('menu_name')->get();
        foreach ($rows as $row) {
            $menus[$row->menu_group][$row->menu_parent][$row->id]['id'] = $row->id;
            $menus[$row->menu_group][$row->menu_parent][$row->id]['name'] = $row->menu_name;
            // $menus[$row->menu_group][$row->menu_parent][$row->id]['url'] = $row->menu_url;
            $menus[$row->menu_group][$row->menu_parent][$row->id]['uri'] = $row->menu_uri;
            $menus[$row->menu_group][$row->menu_parent][$row->id]['target'] = $row->menu_target;
            $menus[$row->menu_group][$row->menu_parent][$row->id]['icon'] = $row->menu_icon;
            $menus[$row->menu_group][$row->menu_parent][$row->id]['parent'] = $row->menu_parent;
        }
        return $menus;
    }

    public static function build($group)
    {
        $GML = new GMenuLibrary;
        $dataMenu = $GML->getMenus();
        $html_out = $GML->getParents($dataMenu[$group]);
        return $html_out;
    }
    private function getParents($dataMenu)
    {
        $html_out = '';
        if (isset($dataMenu[0])) {
            foreach ($dataMenu[0] as $menu) {
                $menu_id = $menu['id'];
                $menu_name = $menu['name'];
                // $menu_url = $menu['url'];
                $menu_uri = $menu['uri'];
                $menu_icon = $menu['icon'] == '' ? 'fas fa-chevron-right' : $menu['icon'];
                $menu_target = $menu['target'];
                // $menu_url_full = ($menu_url=='')?url('/'.$menu_uri):$menu_url.'/'.$menu_uri;
                $menu_uri_full = $this->admin."/".$menu_uri;
                if (GPermissionLibrary::permissionActive($menu_uri)) {
                    if (!isset($dataMenu[$menu_id])) {
                        $html_out .= '<li>
                                        <a data-request="push" title="' . $menu_name . '" class="nav-link" href="' . url($menu_uri_full) . '">
                                        <i class="' . $menu_icon . '"></i>
                                        <span>' . $menu_name . '</span>
                                        </a>
                                    </li>';
                    } else {
                        $html_out .= '<li class="menu-header">' . $menu_name . '</li>';
                        $html_out .= $this->getChilds($menu_id, $dataMenu);
                    }
                    // $html_out .= '</li>';
                }
            }
        }
        return $html_out;
    }

    private function getChilds($id, $dataSubMenu)
    {
        $has_subcats = false;
        $html_out = '';
        // $html_out .= '<ul class="submenu">';
        foreach ($dataSubMenu[$id] as $smenu) {
            $smenu_id = $smenu['id'];
            $smenu_name = $smenu['name'];
            // $smenu_url = $smenu['url'];
            $smenu_uri = $smenu['uri'];
            $smenu_icon = $smenu['icon'] == '' ? 'fas fa-chevron-right' : $smenu['icon'];
            $smenu_target = $smenu['target'];
            // $smenu_url_full = ($smenu_url=='')?url('/'.$smenu_uri):$smenu_url.'/'.$smenu_uri;
            $menu_uri_full = $this->admin."/".$smenu_uri;
            $has_subcats = true;

            if (GPermissionLibrary::permissionActive($smenu_uri)) {
                if (!isset($dataSubMenu[$smenu_id])) {
                    $html_out .= '<li><a data-request="push" title="' . $smenu_name . '" class="nav-link" href="' . url($menu_uri_full) . '">
                                            <i class="' . $smenu_icon . '"></i>
                                            <span>' . $smenu_name . '</span>
                                        </a></li>';
                }
            }
        }

        // $html_out .= '</ul>';

        return ($has_subcats) ? $html_out : false;
    }
}
