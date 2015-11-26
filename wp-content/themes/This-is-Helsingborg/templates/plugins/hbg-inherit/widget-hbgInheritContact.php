<?php
$data = get_fields($instance['post_id']);
echo $before_widget;
?>
<?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>
<h3 class="box-title"><?php echo (isset($instance['title']) && strlen($instance['title']) > 0) ? $instance['title'] : $post->title; ?></h3>

<div class="box-content padding-x1-5">
    <p>
        <strong><span itemprop="name"><?php echo $data['contact-name']; ?></span></strong>
    </p>

    <?php if (isset($data['contact-show-postal-address']) && !empty($data['contact-show-postal-address'])) : ?>
    <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <strong>Postadress</strong><br>
        <?php if (isset($data['contact-postal-streetaddress']) && !empty($data['contact-postal-streetaddress'])) : ?>
            <span itemprop="streetAddress"><?php echo $data['contact-postal-streetaddress']; ?></span><br>
        <?php endif; ?>
        <?php if (isset($data['contact-postal-zip']) && !empty($data['contact-postal-zip'])) : ?>
            <span itemprop="postalCode"><?php echo $data['contact-postal-zip']; ?></span>
        <?php endif; ?>
        <?php if (isset($data['contact-postal-city']) && !empty($data['contact-postal-city'])) : ?>
            <span itemprop="addressLocality"><?php echo $data['contact-postal-city']; ?></span>
        <?php endif; ?>
    </p>
    <?php endif; ?>

    <?php if (isset($data['contact-show-visiting-address']) && !empty($data['contact-show-visiting-address'])) : ?>
    <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <strong>Besöksadress</strong><br>
        <?php if (isset($data['contact-visit-streetaddress']) && !empty($data['contact-visit-streetaddress'])) : ?>
            <span itemprop="streetAddress"><?php echo $data['contact-visit-streetaddress']; ?></span><br>
        <?php endif; ?>
        <?php if (isset($data['contact-visit-city']) && !empty($data['contact-visit-city'])) : ?>
            <span itemprop="addressLocality"><?php echo $data['contact-visit-city']; ?></span>
        <?php endif; ?>
    </p>
    <?php endif; ?>

    <?php if (isset($data['contact-email']) && !empty($data['contact-email'])) : ?>
    <p itemprop="address">
        <strong>E-postadress</strong><br>
        <a href="mailto:<?php echo $data['contact-email']; ?>" itemprop="email"><?php echo $data['contact-email']; ?></a>
    </p>
    <?php endif; ?>

    <?php if (isset($data['contact-phone']) && !empty($data['contact-phone'])) : ?>
    <p itemprop="address">
        <strong>Telefonnummer</strong><br>
        <a href="tel:<?php echo $data['contact-phone']; ?>" itemprop="telephone"><?php echo $data['contact-phone']; ?></a>
    </p>
    <?php endif; ?>

    <?php if (isset($data['contact-fax']) && !empty($data['contact-fax'])) : ?>
    <p itemprop="address">
        <strong>Fax</strong><br>
        <span itemprop="telephone"><?php echo $data['contact-fax']; ?></span>
    </p>
    <?php endif; ?>
</div>
<?php echo $after_widget; ?>
