<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-zinc-900'); ?>>
<?php wp_body_open(); ?>

<header class="sticky top-0 z-50 bg-zinc-950 border-b border-zinc-800">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">

        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3">
            <span class="w-9 h-9 bg-rose-800 rounded flex items-center justify-center text-white font-semibold text-sm">
                B
            </span>
            <span class="text-lg font-semibold text-white">
                Baglian <span class="text-zinc-400 font-normal">Advocacia</span>
            </span>
        </a>

        <nav class="hidden md:flex items-center gap-6">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'header-menu',
                'container'      => false,
                'menu_class'     => 'flex gap-6 items-center text-sm font-medium text-zinc-300',
                'fallback_cb'    => false,
                'walker'         => new Baglian_Nav_Walker(),
            ));
            ?>

            <?php if (function_exists('pll_the_languages')) : ?>
                <?php $idiomas = pll_the_languages(array('raw' => 1)); ?>
                <div class="flex gap-2 text-sm text-zinc-300 border-l border-zinc-700 pl-6">
                    <?php foreach ($idiomas as $idioma) : ?>
                        <a href="<?php echo esc_url($idioma['url']); ?>" class="<?php echo $idioma['current_lang'] ? 'text-white font-semibold' : 'hover:text-white'; ?> transition">
                            <?php echo esc_html(strtoupper($idioma['slug'])); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </nav>

        <button id="baglian-menu-toggle" class="md:hidden text-white p-2" aria-label="Abrir menu">
            <svg id="icon-menu-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg id="icon-menu-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

    </div>

    <!-- MENU MOBILE (dropdown) -->
    <nav id="baglian-mobile-menu" class="hidden md:hidden bg-zinc-950 border-t border-zinc-800">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'header-menu',
            'container'      => false,
            'menu_class'     => 'flex flex-col gap-1 px-4 py-4 text-sm font-medium text-zinc-300',
            'fallback_cb'    => false,
        ));
        ?>

        <?php if (function_exists('pll_the_languages')) : ?>
            <?php $idiomas_mobile = pll_the_languages(array('raw' => 1)); ?>
            <div class="flex gap-3 px-4 pb-4 text-sm text-zinc-300 border-t border-zinc-800 pt-3">
                <?php foreach ($idiomas_mobile as $idioma) : ?>
                    <a href="<?php echo esc_url($idioma['url']); ?>" class="<?php echo $idioma['current_lang'] ? 'text-white font-semibold' : 'hover:text-white'; ?> transition">
                        <?php echo esc_html(strtoupper($idioma['slug'])); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </nav>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('baglian-menu-toggle');
    var menu = document.getElementById('baglian-mobile-menu');
    var iconOpen = document.getElementById('icon-menu-open');
    var iconClose = document.getElementById('icon-menu-close');

    toggle.addEventListener('click', function () {
        menu.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
    });
});
</script>