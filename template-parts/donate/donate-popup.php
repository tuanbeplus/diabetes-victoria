<?php
/**
 * Displays the Global search popup
 *
 */
$donate = get_field('donate', 'option');
$amount_options = $donate['amount_options'];
?>
<!-- Donate popup -->
<div id="donate-popup" class="donate-popup">
    <div class="donate-wrapper">
        <form method="get" class="donate-form" action="<?php echo esc_url( home_url( '/donate' ) ); ?>">
            <div class="form-inner">
                <p>Choose your amount ($)</p>
                <div class="amount-options">
                    <div class="amounts-list">
                        <?php if (!empty($amount_options)): ?>
                            <?php foreach ($amount_options as $row): ?>
                                <label for="amount-<?php echo $row['amount'] ?>">
                                    <?php echo '$ '.$row['amount'].'.00'; ?>
                                    <input type="radio" name="amount" 
                                            id="amount-<?php echo $row['amount'] ?>"
                                            value="<?php echo $row['amount'] ?>">
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <input type="text" name="amount" id="other-amount" placeholder="Enter amount $">
                    <a class="btn-regular-gift" role="button" href="">Make it a regular gift</a>
                </div>
                <div class="form-footer">
                    <p>Find out <a href="">other ways to get involved</a></p>
                    <button id="btn-continue-donate" type="submit">Continue</button>
                </div>
            </div>
        </form>
        <button id="btn-close-donate">
            <span>Close</span>
            <span class="close-icon"><i class="fa-solid fa-xmark"></i></span>
        </button>
    </div>
    <div class="donate-overlay"></div>
</div><!-- .Donate popup -->