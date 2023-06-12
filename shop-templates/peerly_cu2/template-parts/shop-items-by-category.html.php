<?php defined('CALLED_FROM_NAIL') or die('oooooop.......') ?>

<?php
$showImgClass = 'no-image';
if (!$bGetNewMenu) { ?>

    <div class="pricing-table-wrapper">
        <div class="single-price">
            <div class="spa-price-thumb" style="max-width: 20%;margin-right: 9px;border-style: none;height: auto;width: 100px;min-width: 100px;">
                <img src="<?php echo $item_image ?>">
            </div>
            <p class="title"><?php echo $menuName; ?></p>
            <p class="price"><?php echo price_format($data['price'], $data['currency']) ?></p>
            <p class="desc_demo"><?php echo $data['description'] ?></p>
        </div>

        <div class="item-info-in-grid">
            <a style="margin-left: 30%; text-align: center;" href="https://demo.zozone.de/nail/booking/?do=add-item&amp;item=134">
                <i class="fa fa-calendar"></i>
                <span style="display:block;"><?php echo $lang['BOOK_NOW'] ?></span>
            </a>

            <a class="ati-eye item-view-info" data-id="<?php echo $data['id']; ?>" style="float: right; margin-right: 30%; text-align: center;" href="javascript:void(0)"  data-ref-id="#item456abc-<?php echo $data['id'] ?>" data-catname="<?php echo $data['cat_name'] ?>">
                <i class="fa fa-info-circle"></i>
                <span style="display:block;"><?php echo $lang['READ_MORE'] ?></span>
            </a>
        </div>
    </div>

    <div id="item456abc-<?php echo $data['id'] ?>" class="pricing-table-wrapper-detail" style="display: none;">
        <div class="single-price">
            <div class="spa-price-thumb" style="border-style: none; height: auto; max-width: 20%; margin-right: 9px;">
                <img class="modal_img" style="border-radius: inherit;" src="<?php echo $item_image ?>">
            </div>
            <div class="modal_content_js" style="flex-grow: 1;">
                <p class="modal_title"><?php echo $menuName; ?></p>
                <p class="modal_desc"><?php echo $data['description'] ?></p>
            </div>
            <div class="pricer">
                <?php
                if ($data['show_price']) {
                    if ($data['discount']) {
                        echo sprintf('<del>%s</del>', price_format($data['price'], $data['currency']));
                        echo sprintf('<span>%s</span>', price_format($data['discount'], $data['currency']));
                    } else echo sprintf('<span>%s</span>', price_format($data['price'], $data['currency']));
                }
                ?>
            </div>
        </div>
    </div>



<?php
} else { ?>

    <div class="swiper-slide">
        <!-- Services Start -->
        <div class="single-services text-center">
            <div class="services-image">
                <img class="img-services" src="<?php echo $data['image_path'] . $menuImage ?>">
                <span class="price"> <?php echo $data['price_format'] ?></span>
            </div>

            <?php
            if ($data['show_price']) {
                if ($data['discount']) {
                    echo sprintf('<div class="services-sale"><img src="' . $config['site_url'] . 'shop-templates/peerly/assets/images/salee.png"></div>');
                }
            }
            ?>

            <div class="services-content">
                <h4 class="title"><a href=""><?php echo $data['cat_name'] ?> <i class="fa fa-info-circle"></i></a></h4>
                <a data-id="<?php echo $data['id']; ?>" style="float: right; " href="javascript:void(0)" class="ati-eye item-view-info" data-ref-id="#item-discount-<?php echo $data['id'] ?>" data-catname="<?php echo $data['cat_name'] ?>">
                    
                </a>
            </div>


            <div id="item-discount-<?php echo $data['id'] ?>" class="pricing-table-wrapper-detail" style="display: none;">
                <div class="single-price">
                    <div class="spa-price-thumb" style="border-style: none; height: auto; max-width: 20%; margin-right: 9px;">
                        <img class="modal_img" style="border-radius: inherit;" src="<?php echo $data['image_path'] . $menuImage ?>">
                    </div>
                    <div class="modal_content" style="flex-grow: 1;">
                        <p class="modal_title"><?php echo $data['cat_name']; ?></p>
                        <p class="modal_desc"><?php echo $data['description'] ?></p>
                    </div>
                    <div class="pricer">
                        <?php
                        if ($data['show_price']) {
                            if ($data['discount']) {
                                echo sprintf('<del>%s</del>', price_format($data['price'], $data['currency']));
                                echo sprintf('<span>%s</span>', price_format($data['discount'], $data['currency']));
                            } else echo sprintf('<span>%s</span>', price_format($data['price'], $data['currency']));
                        }
                        ?>
                    </div>

                </div>
            </div>

            <div class="item-calendar" style="background: var(--classic-color-0_8); border-radius: 15px;width: 60%;font-family: 'Alumni Sans';margin: auto; margin-top: 10px;">
                <ul>
                    <li>
                        <a href="https://demo.zozone.de/nail/booking/?do=add-item&amp;item=134" data-id="134" data-catid="23" data-price="80,€" data-duration="90">
                            <i class="fa fa-calendar"></i>
                            <span style="display:block; float: right; padding-left: 10px;font-family: 'Alumni Sans'; "><?php echo $lang['BOOK_NOW'] ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Services End -->
    </div>
<?php
}
?>