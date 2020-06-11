<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - TK Photography</title>
    <?php require 'assets/include/admin/head_meta.php'?>
</head>
<body>
    <div class="container-fluid">
        <?php require 'assets/include/admin/nav.php'?>
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="box">
                        <div class="box-header">
                            <div>Dashboard</div>
                        </div>
                        <div class="box-body">
                            <div class="item-container">
                            	<?php if(!empty($enquiries)): ?>
                            		<?php foreach($enquiries as $enquiry): ?>
		                                <div class="item <?=$enquiry['subject']?>" title="Sent by <?=$enquiry['sender']['name']?>">
		                                	<div class="enquiry"><?=ucfirst($enquiry['subject'])?></div>
		                                	<div class="item-label">
		                                		<div class="label">From:</div>
		                                		<div class="item-text">
		                                			<div class="item-small-detail"><?=$enquiry['sender']['name']?></div>
		                                			<div><?=$enquiry['sender']['email']?></div>
		                                		</div>
		                                	</div>
		                                	<div class="item-label subject-label">
		                                		<div class="label">Subject:</div>
		                                		<div class="item-text">
		                                			<div><?=ucfirst($enquiry['subject'])?></div>
		                                		</div>
		                                	</div>
		                                	<div class="item-label message-label">
		                                		<div class="label">Message:</div>
		                                		<div class="item-text">
		                                			<span><?=$enquiry['message']?></span>
		                                		</div>
		                                	</div>
		                                </div>
		                            <?php endforeach;?>
		                         <?php else: ?>
		                         	<div class="no-enquiries"><h3>No enquiries yet!</h3></div>
		                         <?php endif;?>
                            </div>
                        </div>

                        <?php require 'assets/include/admin/modals/confirm_modal.php'?>

                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <?php require 'assets/include/admin/scripts.php'?>
</body>
</html>