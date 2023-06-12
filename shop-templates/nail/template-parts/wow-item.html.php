<?php defined('CALLED_FROM_NAIL') or die('oooooop.......')?>

<div class="col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
    <div class="item-box m-b10">
        <div class="item-img" 
            data-lazyload = "<?php echo $data['image_path'] . $menuImage?>"
            style="background:url('<?php echo $data['image_path'] . $menuImage ?>');
            background-position: center;background-repeat: no-repeat;background-size: cover;height:387px;">
            <img src="<?php echo $data['image_path'] . $menuImage ?>" alt="<?php echo $menuName?>" style="opacity:.1"/>
            <div class="item-info-in">
                <ul>
                    <li><a href="javascript:void(0);"><i class="ti-shopping-cart"></i></a></li>
                    <li><a href="#" class="ati-eye" data-ref-id="#item-<?php echo $data['id'] ?>" data-toggle="modal" data-target="#itemInfoModal"><i class="ti-eye"></i></a></li>
                    <!--<li><a href="javascript:void(0);"><i class="ti-heart"></i></a></li>-->
                </ul>
            </div>
        </div>
        <div class="item-info text-center text-black p-a10">
            <h6 class="item-title font-weight-500"><a href="shop-product-details.html"><?php echo $menuName?></a></h6>            
            <h4 class="item-price">
                <?php
                if($data['show_price']){
                    if($data['discount']){
                        echo sprintf('<del>%s</del>', price_format($data['price'], $data['currency']));
                        echo sprintf('<span class="text-primary">%s</span>', price_format($data['discount'], $data['currency']));
                    }else echo sprintf('<span class="text-primary">%s</span>', price_format($data['price'], $data['currency']));
                }
                ?>                
            </h4>
        </div>
    </div>
    <div id="item-<?php echo $data['id']?>" class="item-hidden-data" style="display:none">
        <?php
            echo "<br/>extra options:<br/>";
            print_r($data[extras_option]);
            echo "<br/>extra:<br/>";
            global $lang;
            echo '<li><strong>'.$lang['EXTRAS'].'</strong><li>';
            foreach($data['extras'] as $i){
                echo sprintf('<li>%s <span style="float:right;">%s</span></li>', $i['title'], price_format($i['price'], $data['currency']));
            }
            
            echo "<br/>properties:<br/>";
            $data['properties']
        ?>
    </div>
</div>