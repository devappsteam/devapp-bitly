<?php

/*
Plugin Name: DevApps Bit.ly
Plugin URI: https://devapps.com.br/plugins/devapps-bitly
Description: Adiciona um botão de link Bit.ly no rodapé do site com opção de configuração no painel geral do WordPress.
Author: Dev Apps Consultoria e Desenvolvimento de Sistemas
Version: 1.0.0
Author URI: https://devapps.com.br
*/

/**
 * Class DevApps_Bitly
 *
 * Adiciona um botão de link Bit.ly no rodapé e uma opção de configuração no painel geral do WordPress.
 */
class DevApps_Bitly
{
    private static $_instance;

    /**
     * Obtém uma instância única da classe usando o padrão Singleton.
     *
     * @return DevApps_Bitly Instância única da classe.
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Construtor privado para garantir apenas uma instância da classe.
     */
    private function __construct()
    {
        // Adiciona ação para exibir o botão no rodapé do site.
        add_action('wp_footer', array($this, 'da_create_footer_button'));

        // Adiciona ações para a configuração no painel de administração.
        add_action("admin_init", array($this, 'da_custom_settings_section'));
        add_action("admin_init", array($this, 'da_custom_settings_field'));
    }

    /**
     * Exibe o botão no rodapé do site.
     */
    public function da_create_footer_button()
    {
        echo '
            <div style="position: fixed; bottom: 15px; right: 15px; z-index: 100; background: #40C351; border-radius: 100%; height: 60px; width: 60px; display: flex; align-items: center; justify-content: center; box-shadow: 0 3px 10px 2px rgba(0,0,0,.2); opacity: 0; animation: fadeIn .3s ease-in-out .8s forwards;">
                <a href="' . esc_attr(get_option("da_bitly_link", '#')) . '" style="position: relative; display: flex; border-radius: 100%; animation: pulse 2s infinite;" target="_blank" title="Acesse nosso suporte">
                    <svg height="60" width="60" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 508 508" xml:space="preserve">
                        <circle style="fill:#54C0EB;" cx="254" cy="254" r="254"/>
                        <path style="fill:#FFFFFF;" d="M303.7,303.3c30.5-17.3,51-50.1,51-87.6c0-55.7-45.1-100.8-100.8-100.8S153.2,160,153.2,215.6
                            c0,37.6,20.6,70.3,51,87.6C141,319.3,89.7,365,66,424.8c46.5,51.1,113.5,83.2,188,83.2s141.5-32.1,188-83.2
                            C418.3,365,367,319.3,303.7,303.3z"/>
                        <path style="fill:#324A5E;" d="M401.6,182.3h-15.8C370.9,123.4,317.5,79.6,254,79.6s-116.9,43.7-131.8,102.7h-15.8
                            c-5.4,0-9.8,4.4-9.8,9.8V240c0,5.4,4.4,9.8,9.8,9.8h20c6.1,0,10.8-5.5,9.7-11.4c-2-10.4-2.7-21.3-1.8-32.5
                            c4.8-59.3,53.6-106.9,113.1-110.1c69.2-3.8,126.8,51.5,126.8,119.9c0,7.8-0.8,15.3-2.2,22.7c-1.2,6,3.6,11.5,9.6,11.5h1.8
                            c-4.2,13-14.9,37.2-38.3,50.2c-19.6,10.9-44.3,11.9-73.4,2.8c-1.5-6.7-8.9-14.6-16.5-18.3c-9.8-4.9-15.9-0.8-19.4,6.2
                            s-3,14.3,6.7,19.2c8.6,4.3,21.6,5.2,27,0.5c13.9,4.3,26.9,6.5,39,6.5c15,0,28.5-3.3,40.4-10c27.5-15.3,38.8-43.7,42.8-57.2h9.9
                            c5.4,0,9.8-4.4,9.8-9.8v-47.9C411.4,186.7,407,182.3,401.6,182.3z"/>
                    </svg>
                </a>
            </div>

            <style>
                @keyframes fadeIn {
                    to {
                        opacity: 1;
                    }
                }

                @keyframes pulse {
                    0% {
                        transform: scale(1);
                        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
                    }

                    50% {
                        transform: scale(1.2);
                        box-shadow: 0 0 20px 10px rgba(255, 255, 255, 0);
                    }

                    100% {
                        transform: scale(1);
                        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
                    }
                }
            </style>
        ';
    }

    /**
     * Adiciona a seção de configurações Bit.ly no painel de administração.
     */
    public function da_custom_settings_section()
    {
        add_settings_section("da_custom_settings_section", "Configurações Bit.ly", null, "general");
    }

    /**
     * Adiciona o campo de configuração para o link Bit.ly no painel de administração.
     */
    public function da_custom_settings_field()
    {
        add_settings_field("da_bitly_link", "Link Bit.ly", array($this, 'da_display_bitly_link_field'), "general", "da_custom_settings_section");
        register_setting("general", "da_bitly_link");
    }

    /**
     * Exibe o campo de input para o link Bit.ly no painel de administração.
     */
    public function da_display_bitly_link_field()
    {
        $bitly_link = esc_attr(get_option("da_bitly_link"));
        echo "<input type='text' name='da_bitly_link' value='$bitly_link' />";
    }
}


DevApps_Bitly::getInstance();
