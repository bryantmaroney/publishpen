<?php
/**
 * Template Name: My Articles Page
 *
 * @package WordPress
 * @subpackage The_Publisher_Pen
 *
 */

get_header();
if (is_user_logged_in()) {
//Get All Posts by Author
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'numberposts' => -1,
        'author' => $current_user->ID,
    );

    $posts = get_posts($args);

    $total_upvotes = 0;
    $total_downvotes = 0;
    $total_views = 0;
    $total_shares = 0;

    foreach ($posts as $post) {

        //Get Total Upvotes
        $total_upvotes = $total_upvotes + get_field('upvotes', $post->ID);

        //Get Total Downvotes
        $total_downvotes = $total_downvotes + get_field('downvotes', $post->ID);

        //Get Total Viewsc
        $total_views = $total_views + get_field('views', $post->ID);

        //Get Total Shares
        $total_shares = $total_shares + get_field('shares', $post->ID);

    }

//Get Drafts by Author
    $args = array(
        'post_type' => 'post',
        'post_status' => 'draft',
        'numberposts' => -1,
        'author' => $current_user->ID,
    );

    $drafts = get_posts($args);

    //wallet balance
    $wallet_balance = 0.00;

//last paid date
//$last_paid_date = "Not Yet";

//last paid amount
    $last_paid_amount = 0.00;

//total ad views
    $total_ad_views = get_field('total_views', "user_$user_ID");

//Yet to paid
    $yet_to_paid_views = get_field('yet_to_paid_views', "user_$user_ID");

//total earnings
    if ($yet_to_paid_views > 50) {

        $ytp_extra = $yet_to_paid_views % 50;
        $ytp_whole = $yet_to_paid_views - $ytp_extra;
        update_field('extra_views', $ytp_extra, "user_$user_ID");
        update_field('yet_to_paid_whole', $ytp_whole, "user_$user_ID");
        $earnings = (get_field('yet_to_paid_whole', "user_$user_ID") / 50) * 0.05;

    } else {

        $ytp_extra = $yet_to_paid_views % 50;
        $ytp_whole = $yet_to_paid_views - $ytp_extra;
        update_field('extra_views', $ytp_extra, "user_$user_ID");
        update_field('yet_to_paid_whole', $ytp_whole, "user_$user_ID");
        $earnings = 0;
        //$total_earnings = ($total_ad_views/2000)*2;
    }
//YTD
    $earnings_ytd = 0;

//Get All Payouts by Author
    $args = array(
        'post_type' => 'payouts',
        'post_status' => 'publish',
        'numberposts' => -1,
        'author' => $current_user->ID,
    );

    $payouts = get_posts($args);
    $total_earnings = 0;
    $p = 0;
    foreach ($payouts as $payout) {
        if ($p == 0) {
            $lpid = $payout->ID;
            $last_paid_amount = get_field('amount', $lpid);
            $last_paid_date = get_field('date', $lpid);
        }
        $poid = $payout->ID;

        $total_earnings = $total_earnings + get_field('amount', $poid);
        $p++;
    }
    ?>
    <section class="be-content profile" id="please-wait">
        <div class="main-content container-fluid" id="personal-profile-details">
            <div class="row">
                <div class="col-sm-12">
                    <center>
                        <h3>
                            <div class="loader"></div>
                            Please wait
                        </h3>
                    </center>
                </div>
            </div>
        </div>
    </section>
    <section class="be-content profile">
        <?php
        $result_status = $_GET['status'];
        $refresh = $_GET['refresh'];
        if(isset($result_status) || isset($refresh)){
            ?>
            <div class="bts-popup" role="alert">
                <div class="bts-popup-container paypal-status-popup">
                    <div class="icon-box">
                        <?php if($result_status == "SUCCESS"){ ?>
                            <i class="icon mdi mdi-check"></i>
                            <br><br>
                            <h3>PAYMENT SUCCESSFUL</h3>
                        <?php }
                        if($result_status == "PENDING"){ ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 18 18"><path d="M.5 16h17L9 1 .5 16zm9.5-2H8v-2h2v2zm0-3H8V7h2v4z"/></svg>
                            <br><br>
                            <h3>PAYMENT PENDING</h3>
                        <?php }
                        if($refresh == 'refreshed'){ ?>
                            <i class="icon mdi mdi-check"></i>
                            <br><br>
                            <h3>STATUS UPDATED</h3>
                            <?php
                        }
                        ?>
                        <br><br>

                        <button class="btn bts-pop-close">Close</button>
                    </div>

                </div>
            </div>

            <?php
        }
        ?>
        <div class="main-content container-fluid" id="personal-profile-details">
            <div class="row">
                <div class="col-sm-12">
                    <div class="selected-title">
                        <p></p>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="row">
                    <div class="col-12 col-lg-3 col-xl-3">
                        <div class="widget widget-tile">
                            <div class="chart sparkline" id="spark1"></div>
                            <div class="data-info">
                                <div class="desc">Upvotes</div>
                                <div class="value">
                                    <span class="indicator indicator-equal mdi mdi-chevron-right"></span>
                                    <span class="number" data-toggle="counter"><?php echo $total_upvotes; ?></span>
                                </div>
                                <div class="icons-article">
                                    <img src="../wp-content/uploads/2019/09/Upvotes.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 col-xl-3">
                        <div class="widget widget-tile">
                            <div class="chart sparkline" id="spark2"></div>
                            <div class="data-info">
                                <div class="desc">Downvotes</div>
                                <div class="value">
                                    <span class="indicator indicator-equal mdi mdi-chevron-right"></span>
                                    <span id="number1" class="number"
                                          data-toggle="counter"><?php echo $total_downvotes; ?></span>
                                </div>
                                <div class="icons-article">
                                    <img src="../wp-content/uploads/2019/09/Downvotes.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 col-xl-3">
                        <div class="widget widget-tile">
                            <div class="chart sparkline" id="spark3"></div>
                            <div class="data-info">
                                <div class="desc">Views</div>
                                <div class="value">
                                    <span class="indicator indicator-equal mdi mdi-chevron-right"></span>
                                    <span class="number" data-toggle="counter"><?php echo $total_views; ?></span>
                                </div>
                                <div class="icons-article">
                                    <img src="../wp-content/uploads/2019/09/views.png">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3 col-xl-3">
                        <div class="widget widget-tile">
                            <div class="chart sparkline" id="spark4"></div>
                            <div class="data-info">
                                <div class="desc">Shares</div>
                                <div class="value">
                                    <span class="indicator indicator-equal mdi mdi-chevron-right"></span>
                                    <span class="number" data-toggle="counter"><?php echo $total_shares; ?></span>
                                </div>
                                <div class="icons-article">
                                    <img src="../wp-content/uploads/2019/09/shares.png">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row user-display-details">
                                <div class="col-4">
                                    <div class="title">Posted Articles</div>
                                    <div class="counter"><?php echo count($posts); ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="title">Total Earnings</div>
                                    <div class="counter">$<?php echo $total_earnings; ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="title">Earnings</div>
                                    <div class="counter">$<?php echo $earnings; ?></div>
                                </div>
                            </div>
    
                            <div class="row user-display-details">
                                <div class="col-4">
                                    <div class="title">Last Paid Date</div>
                                    <div class="counter"><?php if (isset($last_paid_date)) {
                                            echo date('m/d/Y', strtotime($last_paid_date));
                                        } else {
                                            echo "Not yet";
                                        } ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="title">Last Paid Amount</div>
                                    <div class="counter">$<?php echo $last_paid_amount; ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="title">Total Ads Views</div>
                                    <div class="counter"><?php echo $total_ad_views; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-divider get-pay-header">
                            <div>
                                <span class="mdi mdi-money-box"></span>Amount to Next
                                Payout<strong><span> $<?php echo $earnings; ?></span></strong>
                            </div>

                            <?php echo do_shortcode('[payout amt=' . $earnings . ']'); ?>

                        </div>
                        <div class="card-body progress-body">
                            <div class="progress-section">
                                <div class="progress">
                                    <div
                                            class="progress-bar progress-bar-striped active"
                                            role="progressbar"
                                            aria-valuenow="60"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                    ></div>
                                </div>
                                <span class="active-amount"></span>
                                <!--<span class="total-amount">$10</span> -->
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-3">
                                    <p class="value">$<?php echo $last_paid_amount; ?></p>
                                    <p class="title">Last Payout</p>
                                </div>
                                <div class="col-lg-3 col-md-3 col-3">
                                    <p class="value">$<?php echo $earnings_ytd; ?></p>
                                    <p class="title">YTD</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-divider">
                            <span class="mdi mdi-money-box"></span>Payouts
                        </div>
                        <div class="card-body">
                            <?php if ($payouts) { ?>
                                <table class="table table-sm">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <?php
                                    $total_earnings = 0;
                                    $pendingid = array();

                                    foreach ($payouts as $payout) {

                                        if (get_field('status', $poid) == 'Pending') {
                                            $pendingid[$poid] = get_field('payout_batch_id', $poid);

                                        }
                                        $poid = $payout->ID;
                                        $total_earnings = $total_earnings + get_field('amount', $poid);

                                        ?>
                                        <tr style="cursor:pointer;">
                                            <td><?php echo get_field('date', $poid); ?></td>
                                            <td>PayPal</td>
                                            <td><?php echo get_field('status', $poid); ?></td>
                                            <td>$<?php echo get_field('amount', $poid); ?></td>
                                        </tr>

                                    <?php } ?>

                                    </tbody>
                                </table>
                                <?php if (!empty($pendingid)) { ?>

                                    <form action="#" method="post">

                                        <input type="hidden" name="refresh_payout" value='refresh_payout'>
                                        <label for="refresh-btn" class="refresh-btn-label">Click refresh to get updated
                                            payment status.</label>&ensp;
                                        <input type="submit" id='refresh-btn'
                                               class="btn btn-rounded btn-space btn-primary" value="Refresh status">


                                    </form>
                                    <hr>
                                    <?php
                                }
                                if (isset($_POST['refresh_payout'])) {
                                    foreach ($pendingid as $key => $rid) {
                                        do_shortcode('[payoutrefresh poidr=' . $rid . ' pidr=' . $key . ']');
                                    }
                                }
                                ?>
                            <?php } else { ?>
                                <span>Keep posting great content to get to your first payout.</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            

            <div
                    class="modal fade"
                    id="modal-withdraw"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="modal-withdraw"
                    aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="onWithdraw">
                            <div class="modal-header">
                                <h4>
                                    Get Paid:
                                    <span>${{wallet_balance}}</span>
                                </h4>
                            </div>
                            <div class="modal-body" v-if="!pending_withdraw">
                                <div
                                        class="payment-failed alert alert-danger"
                                        v-if="payment_failed"
                                >Your payment request was failed. Please try again later.
                                </div>
                                <div class="description">
                <span>
                  <!-- Your current earning is ${{wallet_balance}}{{balance_since}} -->
                  Please enter the PayPal email address that you want the above amount to be paid. If you do not have a PayPal account, you can create one
                  <a
                          href="https://www.paypal.com/webapps/mpp/account-selection"
                          target="_blank"
                  >here</a>.
                </span>
                                </div>
                                <div>
                                    <span>PayPal email address</span>
                                    <input
                                            type="email"
                                            v-model="paypal_addr"
                                            @change="pay_validation()"
                                            class="form-control paypal-mail"
                                            required
                                    >

                                    <span>Confirm PayPal email address</span>
                                    <input
                                            type="email"
                                            id="confirm_email"
                                            @change="pay_validation()"
                                            class="form-control paypal-mail"
                                            required
                                    >
                                </div>
                                <div class="payment-information">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p class="title">Amount to be paid</p>
                                            <p class="value">${{wallet_balance}}</p>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <p class="title">Available</p>
                                            <p class="value">Instantly</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="term_conditions">
                                    <input type="checkbox" name="agree_term" @click="pay_validation()">
                                    <label>
                                        I have read and agree to the Publisher Pen's
                                        <a href="#">Terms and Conditions</a>
                                    </label>
                                </div>
                            </div>
                            <div class="modal-body" v-if="pending_withdraw">
                                <div
                                        class="payment-pending"
                                >Your payment is in pending status. You requested withdraw on {{latest_req_date}} and
                                    will be paid on {{expected_paid_date}}.
                                </div>
                            </div>
                            <div class="modal-buttons" v-if="!pending_withdraw">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary btn-pay">Get Paid</button>


                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div
                    class="modal fade"
                    id="modal-pay-success"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="modal-pay-success"
                    aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Payment request success</h4>
                        </div>
                        <div class="modal-body">
                            <i class="fa fa-check"></i>
                            <div class="success-msg">
                                <h3>Awesome! You just got paid!</h3>
                                <p>We just sent ${{wallet_balance}} to {{paypal_addr}} via PayPal.</p>
                                <p>Your earnings will be paid on {{pay_date}}</p>
                            </div>
                            <div class="payment-information">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <p class="title">Amount to be paid</p>
                                        <p class="value">${{wallet_balance}}</p>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <p class="title">Available</p>
                                        <p class="value">Instantly</p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="alert alert-success">Your earnings will be paid on {{ pay_date }}</div> -->
                        </div>
                        <div class="modal-buttons">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-------- Earnings Chart -------->

            <div class="row">

                <!-------- Drafts -------->

                <?php if ($drafts) { ?>

                    <div class="col-lg-12 col-md-12">
                        <div class="card card-table" id="myarticles_more">
                            <div class="card-header"
                                 style="display: flex; justify-content:space-between; align-items:center;">
                                <p class="card-title-article">My Drafts</p>
                                <i class="fas fa-th"></i>
                            </div>
                            <div class="card-body">
                                <div id="view-group">
                                    <table class="table table-hover table-fw-widget dtr-" id="table5"
                                           aria-describedby="table5_info">
                                        <thead>
                                        <tr rol="row">
                                            <th>Title</th>
                                            <th>Last Saved</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($drafts as $draft) {
                                            ?>
                                            <tr rol="row" style="cursor:pointer">
                                                <td><?php echo $draft->post_title; ?></td>
                                                <td><?php echo $draft->post_modified; ?></td>
                                                <td class="action-group">
                                                    <a href="#" class="icon del-class" id="<?php echo $draft->ID; ?>"
                                                       onclick="" data-toggle="modal" data-target="#mod-warning">
                                                        <input type="hidden" id="delId" name="delId"
                                                               value="<?php echo $draft->ID; ?>">
                                                        <span class="mdi mdi-delete"></span>
                                                    </a>
                                                    <a href="<?php echo site_url() . '/create-article?action=draft&id=' . $draft->ID; ?>"
                                                       class="icon">
                                                        <span class="mdi mdi-edit"></span>
                                                    </a>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                <?php } ?>

                <!-------- My Articles -------->

                <div class="col-lg-12 col-md-12">
                    <div class="card card-table" id="myarticles_more">
                        <div class="card-header"
                             style="display: flex; justify-content:space-between; align-items:center;">
                            <p class="card-title-article">My Articles : </p>
                            <!-- <i class="fas fa-th" onclick="onChangeView()"></i>-->
                        </div>
                        <div id="view-group" class="table-view-less">
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <table class="table table-responsive table-hover table-fw-widget dtr-"
                                           id="table5" aria-describedby="table5_info">
                                        <thead>
                                        <tr rol="row">
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Likes</th>
                                            <th>Dislikes</th>
                                            <th>Views</th>
                                            <th>Ad Views</th>
                                            <th>Shares</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (count($posts) > 0) {
                                            foreach ($posts as $post) {
                                                ?>

                                                <tr rol="row" style="cursor:pointer">
                                                    <td valign="center"><?php echo $post->post_title; ?></td>
                                                    <td valign="center"><?php echo $post->post_date; ?></td>
                                                    <td valign="center"
                                                        style="text-align:center;"><?php the_field('upvotes'); ?></td>
                                                    <td valign="center"
                                                        style="text-align:center;"><?php the_field('downvotes'); ?></td>
                                                    <td valign="center"
                                                        style="text-align:center;"><?php the_field('views'); ?></td>
                                                    <td valign="center"
                                                        style="text-align:center;"><?php the_field('ad_views'); ?></td>
                                                    <td valign="center"
                                                        style="text-align:center;"><?php the_field('shares'); ?></td>
                                                    <td valign="center" class="action-group" style="text-align:center;">
                                                        <a href="#" class="icon del-class" id="<?php echo $post->ID; ?>"
                                                           onclick="" data-toggle="modal" data-target="#mod-warning">
                                                            <input type="hidden" id="delId" name="delId"
                                                                   value="<?php echo $post->ID; ?>">
                                                            <span class="fa fa-times"></span>
                                                        </a>
                                                        <a href="<?php echo site_url() . '/create-article?action=edit&id=' . $post->ID; ?>"
                                                           class="icon edit-class">
                                                            <span class="mdi mdi-edit"></span>
                                                        </a>
                                                    </td>
                                                </tr>

                                                <?php
                                            }

                                        } else { ?>

                                            <tr rol="row" style="cursor:pointer">
                                                <td colspan="8">You have not created a post yet.</td>
                                            </tr>


                                        <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="mod-warning" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal" aria-hidden="true">
                            <span class="mdi mdi-close"></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="text-warning">
                                <span class="modal-main-icon mdi mdi-alert-triangle"></span>
                            </div>
                            <h3>Warning!</h3>
                            <p>
                                Articles will be deleted.
                                <br>Are you sure?
                            </p>
                            <div class="mt-8 action-div">
                                <input type="hidden" id="custId" name="custId" value="">
                                <button class="btn btn-space btn-secondary" type="button" data-dismiss="modal">Cancel
                                </button>

                                <button class="btn btn-space btn-warning" id="proceed-delete" type="button"
                                        data-dismiss="modal" @click="onDeleteClick()">Proceed
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
    </section>
    <br><br>
    <?php
} else {
    ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button class="close" type="button" data-dismiss="modal" aria-hidden="true"><span class="mdi mdi-close"></span></button> -->
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <br>
                    <div class="socail-buttons">
                        <ul>
                            <li><a href="https://www.publishpen.com/wp-login.php?loginSocial=facebook" data-plugin="nsl"
                                   data-action="connect" data-redirect="current" data-provider="facebook"
                                   data-popupwidth="475" data-popupheight="175"><span><i class="fab fa-facebook-f"></i></span>
                                    Continue with Facebook </a></li>
                            <li><a href="https://www.publishpen.com/wp-login.php?loginSocial=twitter" data-plugin="nsl"
                                   data-action="connect" data-redirect="current" data-provider="twitter"
                                   data-popupwidth="600" data-popupheight="600"><span><i
                                                class="fab fa-twitter"></i></span> Continue with twitter </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
    <?php
}

get_footer();

?>