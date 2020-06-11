<div class="preview">
    <div class="preview-content">
        <div class="preview-left">
            <div class="preview-header">
                <div>
                    <div class="preview-close activeBtn" title="Close"></div>
                    <div class="preview-options">
                        <ul>
                            <!-- <li id="_view_rotate" class="rotate activeBtn hide" title="Rotate"></li> -->
                            <li id="_info_view" class="info activeBtn" title="Info"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="preview-body">
                <div class="preview-list">
                    <div class="preview-item loading">
                        <div class="item-container">
                            <div class="preview-image">
                                <img src="<?=base_url('assets/img/loading.gif')?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Controls -->
                <div id="_prev" class="control-left active"></div>
                <div class="control-btn left activeBtn"></div>
                <div id="_next" class="control-right active"></div>
                <div class="control-btn right activeBtn"></div>
                <div class="hide">
                    <img height="0" width="0" src="<?=base_url('assets/include/gallery/assets/img/next.png')?>">
                    <img height="0" width="0" src="<?=base_url('assets/include/gallery/assets/img/prev.png')?>">
                    <img height="0" width="0" src="<?=base_url('assets/include/gallery/assets/img/rotate.png')?>">
                    <img height="0" width="0" src="<?=base_url('assets/include/gallery/assets/img/info.png')?>">
                    <img height="0" width="0" src="<?=base_url('assets/include/gallery/assets/img/arrow-left.png')?>">
                    <img height="0" width="0" src="<?=base_url('assets/img/loading.gif')?>" alt="">
                </div>
            </div>
        </div>
        <div class="preview-right">
            <div>
                <div class="info-top">
                    <div role="button" id="_info_close" class="info-close activeBtn" title="Close">&times;</div>
                    <div class="info-text">Info</div>
                </div>
                <div class="info-detail _title">
                    <label for="">Title</label>
                    <div></div>
                </div>
                <div class="info-detail _description">
                    <label for="">Description</label>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</div>