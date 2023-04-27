<?php
namespace tglobally\tg_notificacion\controllers;

use gamboamartin\errores\errores;
use PDO;
use stdClass;
use tglobally\template_tg\html;

class controlador_not_adjunto extends \gamboamartin\notificaciones\controllers\controlador_not_adjunto {

    public array $sidebar;
    public function __construct(PDO $link, stdClass $paths_conf = new stdClass()){
        $html_base = new html();
        parent::__construct( link: $link, html: $html_base);

        $sidebar = $this->init_sidebar();
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al inicializar sidebar', data: $sidebar);
            print_r($error);
            die('Error');
        }
    }

    private function init_sidebar(): stdClass|array
    {
        $menu_items = new stdClass();

        $menu_items->lista = $this->menu_item(menu_item_titulo: "Inicio", link: $this->link_lista);
        $menu_items->alta = $this->menu_item(menu_item_titulo: "Alta", link: $this->link_alta);
        $menu_items->modifica = $this->menu_item(menu_item_titulo: "Modifica", link: $this->link_modifica);

        $menu_items->lista['menu_seccion_active'] = true;
        $menu_items->lista['menu_lateral_active'] = true;
        $menu_items->alta['menu_seccion_active'] = true;
        $menu_items->alta['menu_lateral_active'] = true;
        $menu_items->modifica['menu_lateral_active'] = true;

        $this->sidebar['lista']['titulo'] = "Adjuntos";
        $this->sidebar['lista']['menu'] = array($menu_items->alta);

        $menu_items->alta['menu_seccion_active'] = false;

        $this->sidebar['alta']['titulo'] = "Adjuntos";
        $this->sidebar['alta']['stepper_active'] = true;
        $this->sidebar['alta']['menu'] = array($menu_items->alta);

        $this->sidebar['modifica']['titulo'] = "Adjuntos";
        $this->sidebar['modifica']['stepper_active'] = true;
        $this->sidebar['modifica']['menu'] = array($menu_items->modifica);

        return $menu_items;
    }

    public function menu_item(string $menu_item_titulo, string $link, bool $menu_seccion_active = false,
                              bool   $menu_lateral_active = false): array
    {
        $menu_item = array();
        $menu_item['menu_item'] = $menu_item_titulo;
        $menu_item['menu_seccion_active'] = $menu_seccion_active;
        $menu_item['link'] = $link;
        $menu_item['menu_lateral_active'] = $menu_lateral_active;

        return $menu_item;
    }
}
