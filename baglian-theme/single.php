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

        <div class="mt-12 pt-6 border-t border-gray-200">
            <a href="<?php echo esc_url(home_url('/#noticias')); ?>" class="text-rose-800 font-medium hover:underline">
                ← Voltar para as notícias
            </a>
        </div>

    <?php endwhile; ?>
</article>

<?php get_footer(); ?>