<?php
$data = get_fields($instance['post_id']);

echo $before_widget;
?>
<h2><?php echo (isset($instance['title']) && strlen($instance['title']) > 0) ? $instance['title'] : $post->title; ?></h2>
<div class="divider">
    <div class="upper-divider"></div>
    <div class="lower-divider"></div>
</div>
<div class="textwidget" itemscope itemtype="http://schema.org/Organization">
    <p>
        <strong><span itemprop="name"><?php echo $data['contact-name']; ?></span></strong>
    </p>

    <?php if (isset($data['contact-email'])) : ?>
    <p itemprop="address">
        <strong>Email</strong><br>
        <a href="mailto:<?php echo $data['contact-email']; ?>" itemprop="email"><?php echo $data['contact-email']; ?></a>
    </p>
    <?php endif; ?>

    <?php if (isset($data['contact-phone'])) : ?>
    <p itemprop="address">
        <strong>Telefon</strong><br>
        <a href="tel:<?php echo $data['contact-phone']; ?>" itemprop="telephone"><?php echo $data['contact-phone']; ?></a>
    </p>
    <?php endif; ?>

    <?php if (isset($data['contact-fax'])) : ?>
    <p itemprop="address">
        <strong>Fax</strong><br>
        <span itemprop="telephone"><?php echo $data['contact-fax']; ?></span>
    </p>
    <?php endif; ?>

    <?php if (isset($data['contact-show-visiting-address'])) : ?>
    <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <strong>Besöksadress</strong><br>
        <span itemprop="streetAddress"><?php echo $data['contact-visit-streetaddress']; ?></span><br>
        <span itemprop="addressLocality"><?php echo $data['contact-visit-city']; ?></span>
    </p>
    <?php endif; ?>

    <?php if (isset($data['contact-show-postal-address'])) : ?>
    <p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <strong>Postadress</strong><br>
        <span itemprop="streetAddress"><?php echo $data['contact-postal-streetaddress']; ?></span><br>
        <span itemprop="postalCode"><?php echo $data['contact-postal-zip']; ?></span>
        <span itemprop="addressLocality"><?php echo $data['contact-postal-city']; ?></span>
    </p>
    <?php endif; ?>

</div>
<?php echo $after_widget; ?>