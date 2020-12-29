<a href="<?= home_url() ?>" class="icon-svg icon-svg_logotype">
    <?php if (get_field('logo', 'options')) : ?>
        <?= file_get_contents(get_field('logo', 'options')) ?>

    <?php endif; ?>

</a>
