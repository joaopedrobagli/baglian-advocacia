<?php get_header(); ?>

<section class="bg-gray-50 py-20">
    <div class="max-w-4xl mx-auto px-4">

        <?php if (have_posts()) : ?>

            <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-10 text-center">
                <?php
                if (is_search()) {
                    echo 'Resultados para: <span class="text-rose-800">' . esc_html(get_search_query()) . '</span>';
                } else {
                    echo 'Conteúdo do <span class="text-rose-800">Site</span>';
                }
                ?>
            </h1>

            <div class="space-y-6">
                <?php while (have_posts()) : the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="block bg-white border border-gray-200 rounded-lg p-6 hover:-translate-y-1 transition">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2"><?php the_title(); ?></h2>
                        <p class="text-gray-500 text-sm mb-3"><?php echo get_the_date(); ?></p>
                        <p class="text-gray-600"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
                    </a>
                <?php endwhile; ?>
            </div>

        <?php else : ?>

            <div class="text-center py-16">
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-4">
                    Nada <span class="text-rose-800">encontrado</span>
                </h1>
                <p class="text-gray-500 mb-8">Não encontramos nenhum conteúdo nessa página.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-rose-800 text-white px-6 py-3 rounded-full font-semibold hover:bg-rose-700 transition">
                    Voltar para a Home
                </a>
            </div>

        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>