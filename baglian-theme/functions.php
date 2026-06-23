<?php
/**
 * Baglian Theme functions and definitions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Walker customizado para o menu do header:
 * o último item (Contato) recebe estilo de botão (pill com borda vinho)
 */
class Baglian_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $is_last = in_array('menu-item-contato', $item->classes) || strtolower($item->title) === 'contato';

        if ($is_last) {
            $output .= '<a href="' . esc_url($item->url) . '" class="border border-rose-400 text-rose-400 px-4 py-2 rounded-full hover:bg-rose-400 hover:text-zinc-900 transition">' . esc_html($item->title) . '</a>';
        } else {
            $output .= '<a href="' . esc_url($item->url) . '" class="hover:text-white transition">' . esc_html($item->title) . '</a>';
        }
    }
}

/**
 * Enfileira o CSS compilado do Tailwind
 */
function baglian_enqueue_assets() {
    wp_enqueue_style(
        'baglian-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/style.css')
    );
}
add_action('wp_enqueue_scripts', 'baglian_enqueue_assets');

/**
 * Registra o menu do header
 */
function baglian_register_menus() {
    register_nav_menus(array(
        'header-menu' => __('Menu Header', 'baglian-theme'),
    ));
}
add_action('after_setup_theme', 'baglian_register_menus');

/**
 * Suporte a recursos do tema
 */
function baglian_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'baglian_theme_setup');

/**
 * Custom Post Type: Advogados
 */
function baglian_register_cpt_advogados() {
    $labels = array(
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

    $args = array(
        'label'                 => __('Advogados', 'baglian-theme'),
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => false,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'menu_icon'             => 'dashicons-businessperson',
        'supports'              => array('title', 'thumbnail'),
        'rewrite'               => array('slug' => 'advogados'),
    );

    register_post_type('advogado', $args);
}
add_action('init', 'baglian_register_cpt_advogados');

/**
 * Página de Configurações do Site (substitui ACF Options Page,
 * que é recurso exclusivo do ACF PRO)
 */

// 1. Adiciona o item de menu
function baglian_add_settings_page() {
    add_options_page(
        'Configurações do Site',
        'Configurações do Site',
        'manage_options',
        'baglian-configuracoes',
        'baglian_render_settings_page'
    );
}
add_action('admin_menu', 'baglian_add_settings_page');

// 2. Registra os campos via Settings API
function baglian_register_settings() {
    register_setting('baglian_settings_group', 'baglian_endereco', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_telefone', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_email', array('sanitize_callback' => 'sanitize_email'));
    register_setting('baglian_settings_group', 'baglian_whatsapp', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_horario', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_copyright', array('sanitize_callback' => 'sanitize_text_field'));
    register_setting('baglian_settings_group', 'baglian_maps_embed', array('sanitize_callback' => 'sanitize_text_field'));
}
add_action('admin_init', 'baglian_register_settings');

// 3. Renderiza o formulário HTML da página
function baglian_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Configurações do Site</h1>
        <p>Estas informações são usadas no rodapé e na página de Contato do site.</p>
        <form method="post" action="options.php">
            <?php settings_fields('baglian_settings_group'); ?>
            <table class="form-table">
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