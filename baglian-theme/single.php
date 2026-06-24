<?php get_header(); ?>

<article class="max-w-3xl mx-auto px-4 py-16">
    <?php while (have_posts()) : the_post(); ?>

        <p class="text-rose-800 text-sm font-medium mb-2"><?php echo get_the_date(); ?></p>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6"><?php the_title(); ?></h1>

        <?php if (has_post_thumbnail()) : ?>
            <div class="mb-8">
                <?php the_post_thumbnail('large', array('class' => 'w-full h-80 object-cover rounded-lg')); ?>
            </div>
        <?php endif; ?>

        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
            <?php the_content(); ?>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-12">
            <?php
            $post_anterior = get_previous_post();
            if ($post_anterior) :
            ?>
                <a href="<?php echo esc_url(get_permalink($post_anterior)); ?>" class="block p-4 border border-gray-200 rounded-lg hover:border-rose-800 transition">
                    <span class="text-xs text-gray-500 block mb-1">← Anterior</span>
                    <span class="text-sm font-medium text-gray-900"><?php echo esc_html(get_the_title($post_anterior)); ?></span>
                </a>
            <?php else : ?>
                <span></span>
            <?php endif; ?>

            <?php
            $proximo_post = get_next_post();
            if ($proximo_post) :
            ?>
                <a href="<?php echo esc_url(get_permalink($proximo_post)); ?>" class="block p-4 border border-gray-200 rounded-lg text-right hover:border-rose-800 transition">
                    <span class="text-xs text-gray-500 block mb-1">Próximo →</span>
                    <span class="text-sm font-medium text-gray-900"><?php echo esc_html(get_the_title($proximo_post)); ?></span>
                </a>
            <?php endif; ?>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200">
          <a href="<?php echo esc_url(pll_home_url() . '#noticias'); ?>" class="text-rose-800 font-medium hover:underline">
          <?php echo pll__('← Voltar para as notícias'); ?>
         </a>
        </div>

    <?php endwhile; ?>
</article>

<?php get_footer(); ?>