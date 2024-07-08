<?php
/**
 * Displays the Donate popup
 *
 */
$donate = get_field('donate', 'option');
$donate_page = $donate['donate_page'];
$amount_options = $donate['amount_options'];
$other_ways_link = $donate['other_ways_to_get_involved'];
?>
<!-- Donate popup -->
<div id="donate-popup" class="donate-popup">
    <div class="donate-wrapper">
        <form method="get" class="donate-form" action="<?php echo esc_url( $donate_page ); ?>">
            <div class="form-inner">
                <fieldset>
                    <legend>Choose your amount ($)</legend>
                    <div class="amount-options">
                        <div class="amounts-list">
                            <?php if (!empty($amount_options)): ?>
                                <?php foreach ($amount_options as $row): ?>
                                    <input type="radio" name="amount" 
                                            id="amount-<?php echo $row['amount'] ?>"
                                            value="<?php echo $row['amount'] ?>">
                                    <label for="amount-<?php echo $row['amount'] ?>">
                                        <?php echo '$'.$row['amount'].'.00'; ?>
                                    </label>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <input type="number" name="amount" id="other-amount" placeholder="Or enter an amount $">
                        <a id="btn-regular-gift" role="button" href="">Make it a regular gift</a>
                    </div>
                </fieldset>
                <div class="form-footer">
                    <p>Find out <a href="<?php echo $other_ways_link; ?>">other ways to get involved</a></p>
                    <button id="btn-continue-donate" type="submit">Continue</button>
                </div>
            </div>
        </form>
        <button id="btn-close-donate">
            <span>Close</span>
            <span class="close-icon"><i class="fa-solid fa-xmark"></i></span>
        </button>
    </div>
</div><!-- .Donate popup -->