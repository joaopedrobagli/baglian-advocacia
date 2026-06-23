<?php get_header(); ?>

<?php
$hero_titulo     = get_field('hero_titulo');
$hero_subtitulo  = get_field('hero_subtitulo');
$hero_imagem     = get_field('hero_imagem');
$hero_cta_texto  = get_field('hero_cta_texto');
$hero_cta_link   = get_field('hero_cta_link');
$quem_somos      = get_field('quem_somos_texto');
?>

<!-- HERO BANNER -->
<section class="relative bg-zinc-950 overflow-hidden">
    <?php if ($hero_imagem) : ?>
        <div class="absolute inset-0">
            <img src="<?php echo esc_url($hero_imagem['url']); ?>" alt="" class="w-full h-full object-cover opacity-30 blur-sm scale-105">
            <div class="absolute inset-0 bg-zinc-950/70"></div>
        </div>
    <?php endif; ?>

    <div class="relative z-10 max-w-7xl mx-auto px-4 py-20 md:py-28 grid md:grid-cols-2 items-center gap-10">
        <div>
            <p class="text-rose-500 font-semibold tracking-widest uppercase text-sm mb-4">
                <?php bloginfo('name'); ?>
            </p>
            <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-6">
                <?php echo esc_html($hero_titulo); ?>
            </h1>
            <p class="text-gray-200 text-lg mb-8">
                <?php echo esc_html($hero_subtitulo); ?>
            </p>
            <?php if ($hero_cta_texto && $hero_cta_link) : ?>
                <a href="<?php echo esc_url($hero_cta_link); ?>" class="inline-block bg-rose-800 text-white px-8 py-4 rounded-full font-semibold hover:bg-rose-700 transition">
                    <?php echo esc_html($hero_cta_texto); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($hero_imagem) : ?>
            <div class="hidden md:flex justify-center">
                <div class="w-80 h-80 rounded-full overflow-hidden ring-4 ring-rose-800/40 shadow-2xl">
                    <img src="<?php echo esc_url($hero_imagem['url']); ?>" alt="<?php echo esc_attr($hero_imagem['alt']); ?>" class="w-full h-full object-cover">
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- QUEM SOMOS -->
<section id="quem-somos" class="bg-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-4">Quem <span class="text-rose-800">Somos</span></h2>
        <p class="text-gray-700 text-lg leading-relaxed mb-12 max-w-2xl mx-auto"><?php echo esc_html($quem_somos); ?></p>

        <div class="grid grid-cols-3 gap-4 max-w-2xl mx-auto">
            <div class="bg-white border-t-2 border-rose-800 rounded-b-lg py-6 shadow-sm hover:-translate-y-1 transition">
                <svg class="w-6 h-6 mx-auto text-rose-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-3xl font-bold text-gray-900 mt-2">20+</p>
                <p class="text-gray-500 text-sm mt-1">Anos de atuação</p>
            </div>
            <div class="bg-white border-t-2 border-rose-800 rounded-b-lg py-6 shadow-sm hover:-translate-y-1 transition">
                <svg class="w-6 h-6 mx-auto text-rose-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m-3 0h14a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/></svg>
                <p class="text-3xl font-bold text-gray-900 mt-2">500+</p>
                <p class="text-gray-500 text-sm mt-1">Casos atendidos</p>
            </div>
            <div class="bg-white border-t-2 border-rose-800 rounded-b-lg py-6 shadow-sm hover:-translate-y-1 transition">
                <svg class="w-6 h-6 mx-auto text-rose-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-3xl font-bold text-gray-900 mt-2">98%</p>
                <p class="text-gray-500 text-sm mt-1">Satisfação</p>
            </div>
        </div>
    </div>
</section>

<!-- ADVOGADOS -->
<section id="advogados" class="bg-zinc-900 py-20">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-semibold text-white text-center mb-12">Nossos <span class="text-rose-400">Advogados</span></h2>

        <?php
        $advogados_query = new WP_Query(array(
            'post_type'      => 'advogado',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ));
        ?>

        <?php if ($advogados_query->have_posts()) : ?>
            <div class="grid md:grid-cols-3 gap-8">
                <?php while ($advogados_query->have_posts()) : $advogados_query->the_post(); ?>
                    <div class="bg-zinc-800 rounded-lg overflow-hidden hover:-translate-y-1 transition">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', array('class' => 'w-full h-56 object-cover')); ?>
                        <?php else : ?>
                            <div class="w-full h-56 bg-zinc-700 flex items-center justify-center text-zinc-500 text-sm">Sem foto</div>
                        <?php endif; ?>
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-semibold text-white mb-1"><?php the_title(); ?></h3>
                            <p class="text-rose-400 text-sm mb-3"><?php echo esc_html(get_field('especialidade')); ?></p>
                            <p class="text-gray-400 text-sm mb-3"><?php echo esc_html(get_field('descricao')); ?></p>
                            <p class="text-gray-500 text-xs"><?php echo esc_html(get_field('oab')); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="text-center text-gray-400">Nenhum advogado cadastrado ainda.</p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>

<!-- ÚLTIMAS NOTÍCIAS -->
<section id="noticias" class="bg-white py-20">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-900 text-center mb-12">Últimas <span class="text-rose-800">Notícias</span></h2>

        <?php
        $noticias_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        $posts_noticias = $noticias_query->posts;
        ?>

        <?php if (!empty($posts_noticias)) : ?>
            <div class="grid md:grid-cols-[1.3fr_1fr] gap-6">

                <!-- POST DE DESTAQUE -->
                <?php
                $destaque = $posts_noticias[0];
                ?>
                <a href="<?php echo esc_url(get_permalink($destaque)); ?>" class="relative rounded-lg overflow-hidden block group">
                    <?php if (has_post_thumbnail($destaque)) : ?>
                        <?php echo get_the_post_thumbnail($destaque, 'large', array('class' => 'w-full h-72 object-cover group-hover:scale-105 transition duration-500')); ?>
                    <?php else : ?>
                        <div class="w-full h-72 bg-gray-200"></div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <p class="text-rose-400 text-xs font-medium mb-1"><?php echo get_the_date('', $destaque); ?></p>
                        <h3 class="text-white text-xl font-semibold leading-snug"><?php echo esc_html(get_the_title($destaque)); ?></h3>
                    </div>
                </a>

                <!-- LISTA COMPACTA -->
                <div class="flex flex-col gap-5">
                    <?php
                    $resto = array_slice($posts_noticias, 1, 2);
                    foreach ($resto as $post_item) :
                    ?>
                        <a href="<?php echo esc_url(get_permalink($post_item)); ?>" class="block pb-5 border-b border-gray-200 last:border-0 group">
                            <p class="text-rose-800 text-xs font-medium mb-1"><?php echo get_the_date('', $post_item); ?></p>
                            <h3 class="text-gray-900 font-semibold group-hover:text-rose-800 transition"><?php echo esc_html(get_the_title($post_item)); ?></h3>
                            <p class="text-gray-500 text-sm mt-1"><?php echo wp_trim_words(get_the_excerpt($post_item), 14); ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>

            </div>
        <?php else : ?>
            <p class="text-center text-gray-500">Nenhuma notícia publicada ainda.</p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>

<!-- CONTATO -->
<section id="contato" class="bg-gray-50 py-20">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-semibold text-gray-900 text-center mb-4">Encontre-nos <span class="text-rose-800">Facilmente</span></h2>
        <p class="text-gray-500 text-center mb-12">Estamos prontos para atender você. Confira nossos dados de contato e localização.</p>

        <div class="grid md:grid-cols-2 gap-8 items-start">

            <!-- CARD DE INFORMAÇÕES -->
            <div class="bg-white border border-gray-200 rounded-lg p-8">
                <div class="flex items-start gap-3 mb-6">
                    <svg class="w-6 h-6 text-rose-800 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-lg mb-1">Nosso Endereço</h3>
                        <p class="text-gray-600"><?php echo esc_html(get_option('baglian_endereco')); ?></p>
                    </div>
                </div>

                <div class="space-y-3 pt-6 border-t border-gray-100">
                    <p class="text-gray-600">
                        <span class="font-medium text-gray-900">Telefone:</span>
                        <?php echo esc_html(get_option('baglian_telefone')); ?>
                    </p>
                    <p class="text-gray-600">
                        <span class="font-medium text-gray-900">WhatsApp:</span>
                        <?php echo esc_html(get_option('baglian_whatsapp')); ?>
                    </p>
                    <p class="text-gray-600">
                        <span class="font-medium text-gray-900">E-mail:</span>
                        <a href="mailto:<?php echo esc_attr(get_option('baglian_email')); ?>" class="hover:text-rose-800">
                            <?php echo esc_html(get_option('baglian_email')); ?>
                        </a>
                    </p>
                    <p class="text-gray-600">
                        <span class="font-medium text-gray-900">Horário:</span>
                        <?php echo esc_html(get_option('baglian_horario')); ?>
                    </p>
                </div>
            </div>

            <!-- MAPA -->
            <div class="rounded-lg overflow-hidden border border-gray-200 h-full min-h-[350px]">
                <?php
                $maps_url = get_option('baglian_maps_embed');
                if ($maps_url) :
                ?>
                    <iframe
                        src="<?php echo esc_url($maps_url); ?>"
                        class="w-full h-full min-h-[350px]"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                <?php else : ?>
                    <div class="w-full h-full min-h-[350px] bg-gray-100 flex items-center justify-center text-gray-400">
                        Mapa não configurado
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>