<?php defined('CALLED_FROM_NAIL') or die('oooooop.......')?>

<?php
$showImgClass = 'no-image';
if(!$bGetNewMenu){?>
    <div class="col-lg-6 col-md-12 col-sm-12">
        <ul class="spa-price-tbl">
            <li>
                <?php
                if($data['show_image']){
                    $showImgClass = '';
                    ?>
                    <div class="spa-price-thumb">
                        <img src="<?php echo $item_image ?>" alt="">                    
                    </div>
                <?php 
                }?>
                <div class="spa-price-content <?php echo $showImgClass?>">
                    <h4>
                        <a href="javascript:;" class="nail-service-item" data-id="<?php echo $data['id']?>" 
                            data-catid="<?php echo $data['cat_id']?>" data-price="<?php echo $data['price_format']?>"><?php echo $menuName;?>
                        </a>
                        <div class="prices-wrap" style="display:block;position:absolute;right:15px;top:10px;">
                        <?php
                        if($data['show_price']){
                            if($data['discount']){
                                echo sprintf('<del class="spa-price ml-auto xs-pos">%s</del>', price_format($data['price'], $data['currency']));
                                echo sprintf('<span class="spa-price xs-pos">%s</span>', price_format($data['discount'], $data['currency']));                                
                            }else echo sprintf('<span class="spa-price ml-auto">%s</span>', price_format($data['price'], $data['currency']));                            
                        }
                        ?>   
                        </div>                 
                    </h4>
                    <p><?php echo $data['description']?></p>
                </div>
                <div class="item-info-in">
                    <ul>
                        <?php
                        if($data['show_order']){?>
                        <li>
                            <a href="#" data-id="<?php echo $data['id']?>" 
                                data-catid="<?php echo $data['cat_id']?>" 
                                data-duration="<?php echo $data['duration']?>"
                                data-toggle="modal" 
                                data-target="#serviceBookingModal"><i class="fa fa-calendar"></i></a></li>
                        <?php }?>
                        <li><a href="#" class="ati-eye" data-ref-id="#item-<?php echo $data['id'] ?>" data-toggle="modal" data-target="#itemInfoModal"
                               data-catname="<?php echo $data['cat_name']?>">
                               <i class="fa fa-info-circle"></i>
                            </a>
                        </li>                        
                    </ul>
                </div>
            </li>
        </ul>
        <?php _itemExtraInfo($data); ?>
    </div>
<?php
}else{?>
    <div class="col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
        <div class="item-box m-b10">            
            <div class="item-img" 
                data-lazyload = "<?php echo $data['image_path'] . $menuImage?>"
                style="background:url('<?php echo $data['image_path'] . $menuImage ?>');
                background-position: center;background-repeat: no-repeat;background-size: cover;height:380px;">
                <?php echo $data['ribbon'] ?>
                <img src="<?php echo $data['image_path'] . $menuImage ?>" alt="<?php echo $menuName?>" style="opacity:.1"/>
                <div class="item-info-in">
                    <ul>
                        <?php
                        if($data['show_order']){?>
                        <li>
                            <a href="#booking" data-id="<?php echo $data['id']?>" 
                                data-catid="<?php echo $data['cat_id']?>" data-toggle="modal" 
                                data-price="<?php echo $data['price_format']?>" 
                                data-target="#serviceBookingModal"
                                data-duration="<?php echo $data['duration']?>">
                                <i class="fa fa-calendar"></i>
                            </a></li>
                        <?php 
                        }?>
                        <li><a href="#" class="ati-eye" data-ref-id="#item-<?php echo $data['id'] ?>" data-toggle="modal" data-target="#itemInfoModal"
                                data-catname="<?php echo $data['cat_name']?>">
                                <i class="fa fa-info-circle"></i>
                            </a>
                        </li>
                        <!--<li><a href="javascript:void(0);"><i class="ti-heart"></i></a></li>-->
                    </ul>
                </div>
            </div>
            <div class="item-info text-center text-black p-a10">
                <h6 class="item-title font-weight-500"><a href="javascript:;"><?php echo $menuName?></a></h6>
                <h4 class="item-price">
                    <?php
                    if($data['show_price']){
                        if($data['discount']){
                            echo sprintf('<del>%s</del>', price_format($data['price'], $data['currency']));
                            echo sprintf('<span>%s</span>', price_format($data['discount'], $data['currency']));
                        }else echo sprintf('<span>%s</span>', price_format($data['price'], $data['currency']));
                    }
                    ?>                
                </h4>
                <p><?php echo $data['description']?></p>
            </div>
        </div>
        <?php         
        _itemExtraInfo($data);         
        ?>
    </div>
<?php
}/////////////////////////////////////////////////////////
?>    