<?php
/**
 * Funções e definições do tema Baglian
 */

if (!defined('ABSPATH')) {
    exit;
}

class Baglian_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $e_ultimo = in_array('menu-item-contato', $item->classes) || strtolower($item->title) === 'contato';

        if ($e_ultimo) {
            $output .= '<a href="' . esc_url($item->url) . '" class="border border-rose-400 text-rose-400 px-4 py-2 rounded-full hover:bg-rose-400 hover:text-zinc-900 transition">' . esc_html($item->title) . '</a>';
        } else {
            $output .= '<a href="' . esc_url($item->url) . '" class="hover:text-white transition">' . esc_html($item->title) . '</a>';
        }
    }
}

function baglian_carrega_estilos() {
    wp_enqueue_style(
        'baglian-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/style.css')
    );
}
add_action('wp_enqueue_scripts', 'baglian_carrega_estilos');


function baglian_cadastra_menus() {
    register_nav_menus(array(
        'header-menu' => __('Menu Header', 'baglian-theme'),
    ));
}
add_action('after_setup_theme', 'baglian_cadastra_menus');

function baglian_configura_tema() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'baglian_configura_tema');

function baglian_cadastra_cpt_advogados() {
    $rotulos = array(
        'name'                  => __('Advogados', 'baglian-theme'),
        'singular_name'         => __('Advogado', 'baglian-theme'),
        'menu_name'             => __('Advogados', 'baglian-theme'),
        'add_new'               => __('Adicionar novo', 'baglian-theme'),
        'add_new_item'          => __('Adicionar novo Advogado', 'baglian-theme'),
        'edit_item'             => __('Editar Advogado', 'baglian-theme'),
        'new_item'              => __('Novo Advogado', 'baglian-theme'),
        'view_item'             => __('Ver Advogado', 'baglian-theme'),
        'search_items'          => __('Buscar Advogados', 'baglian-theme'),
        'not_found'             => __('Nenhum advogado encontrado', 'baglian-theme'),
        'all_items'             => __('Todos os Advogados', 'baglian-theme'),
    );

    $opcoes = array(
        'label'                 => __('Advogados', 'baglian-theme'),
        'labels'                => $rotulos,
        'public'                => true,
        'has_archive'           => false,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'menu_icon'             => 'dashicons-businessperson',
        'supports'              => array('title', 'thumbnail'),
        'rewrite'               => array('slug' => 'advogados'),
    );

    register_post_type('advogado', $opcoes);
}
add_action('init', 'baglian_cadastra_cpt_advogados');

function baglian_adiciona_pagina_configuracoes() {
    add_options_page(
        'Configurações do Site',
        'Configurações do Site',
        'manage_options',
        'baglian-configuracoes',
        'baglian_exibe_pagina_configuracoes'
    );
}
add_action('admin_menu', 'baglian_adiciona_pagina_configuracoes');

function baglian_cadastra_configuracoes() {
    register_setting('baglian_settings_group', 'baglian_tagline', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_endereco', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_telefone', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_email', array('sanitize_callback' => 'sanitize_email'));
    register_setting('baglian_settings_group', 'baglian_whatsapp', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_horario', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_copyright', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_maps_embed', array('sanitize_callback' => 'sanitize_text_field'));
}
add_action('admin_init', 'baglian_cadastra_configuracoes');

function baglian_exibe_pagina_configuracoes() {
    ?>
    <div class="wrap">
        <h1>Configurações do Site</h1>
        <p>Estas informações são usadas no rodapé e na página de Contato do site.</p>
        <form method="post" action="options.php">
            <?php settings_fields('baglian_settings_group'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="baglian_tagline">Tagline (frase curta do rodapé)</label></th>
                    <td><input type="text" id="baglian_tagline" name="baglian_tagline" value="<?php echo esc_attr(get_option('baglian_tagline')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="baglian_endereco">Endereço</label></th>
                    <td><input type="text" id="baglian_endereco" name="baglian_endereco" value="<?php echo esc_attr(get_option('baglian_endereco')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="baglian_maps_embed">Google Maps - URL de Embed</label></th>
                    <td>
                        <input type="text" id="baglian_maps_embed" name="baglian_maps_embed" value="<?php echo esc_attr(get_option('baglian_maps_embed')); ?>" class="regular-text">
                        <p class="description">Cole aqui a URL do campo "src" do código de incorporação do Google Maps (Compartilhar &gt; Incorporar um mapa &gt; copiar a URL dentro de src="...").</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="baglian_telefone">Telefone</label></th>
                    <td><input type="text" id="baglian_telefone" name="baglian_telefone" value="<?php echo esc_attr(get_option('baglian_telefone')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="baglian_email">E-mail</label></th>
                    <td><input type="email" id="baglian_email" name="baglian_email" value="<?php echo esc_attr(get_option('baglian_email')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="baglian_whatsapp">WhatsApp</label></th>
                    <td><input type="text" id="baglian_whatsapp" name="baglian_whatsapp" value="<?php echo esc_attr(get_option('baglian_whatsapp')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="baglian_horario">Horário de atendimento</label></th>
                    <td><input type="text" id="baglian_horario" name="baglian_horario" value="<?php echo esc_attr(get_option('baglian_horario')); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="baglian_copyright">Texto de Copyright</label></th>
                    <td><input type="text" id="baglian_copyright" name="baglian_copyright" value="<?php echo esc_attr(get_option('baglian_copyright')); ?>" class="regular-text"></td>
                </tr>
            </table>
            <?php submit_button('Salvar configurações'); ?>
        </form>
    </div>
    <?php
}
function baglian_registra_strings_traduzveis() {
    if (function_exists('pll_register_string')) {
        pll_register_string('quem_somos_titulo', 'Quem Somos', 'Baglian Theme');
        pll_register_string('estatistica_anos', 'Anos de atuação', 'Baglian Theme');
        pll_register_string('estatistica_casos', 'Casos atendidos', 'Baglian Theme');
        pll_register_string('estatistica_satisfacao', 'Satisfação', 'Baglian Theme');
        pll_register_string('advogados_titulo', 'Nossos Advogados', 'Baglian Theme');
        pll_register_string('advogados_sem_foto', 'Sem foto', 'Baglian Theme');
        pll_register_string('advogados_vazio', 'Nenhum advogado cadastrado ainda.', 'Baglian Theme');
        pll_register_string('noticias_titulo', 'Últimas Notícias', 'Baglian Theme');
        pll_register_string('noticias_vazio', 'Nenhuma notícia publicada ainda.', 'Baglian Theme');
        pll_register_string('contato_titulo', 'Encontre-nos Facilmente', 'Baglian Theme');
        pll_register_string('contato_subtitulo', 'Estamos prontos para atender você. Confira nossos dados de contato e localização.', 'Baglian Theme');
        pll_register_string('contato_endereco_label', 'Nosso Endereço', 'Baglian Theme');
        pll_register_string('contato_telefone_label', 'Telefone:', 'Baglian Theme');
        pll_register_string('contato_whatsapp_label', 'WhatsApp:', 'Baglian Theme');
        pll_register_string('contato_email_label', 'E-mail:', 'Baglian Theme');
        pll_register_string('contato_horario_label', 'Horário:', 'Baglian Theme');
        pll_register_string('contato_mapa_vazio', 'Mapa não configurado', 'Baglian Theme');
        pll_register_string('footer_tagline', get_option('baglian_tagline'), 'Baglian Theme');
        pll_register_string('footer_copyright', get_option('baglian_copyright'), 'Baglian Theme');
        pll_register_string('voltar_noticias', '← Voltar para as notícias', 'Baglian Theme');
    }
}
add_action('init', 'baglian_registra_strings_traduzveis');