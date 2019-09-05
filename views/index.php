<?php
\shahimian\chess\Assets::register($this);
?>
<div id="box">
    <div id="board">
        <div class="white-pawn" id="wp-1"<?php if(isset($movements['wp-1'])): ?> style="top: <?= $movements['wp-1']['y']; ?>px; left: <?= $movements['wp-1']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-pawn" id="wp-2"<?php if(isset($movements['wp-2'])): ?> style="top: <?= $movements['wp-2']['y']; ?>px; left: <?= $movements['wp-2']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-pawn" id="wp-3"<?php if(isset($movements['wp-3'])): ?> style="top: <?= $movements['wp-3']['y']; ?>px; left: <?= $movements['wp-3']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-pawn" id="wp-4"<?php if(isset($movements['wp-4'])): ?> style="top: <?= $movements['wp-4']['y']; ?>px; left: <?= $movements['wp-4']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-pawn" id="wp-5"<?php if(isset($movements['wp-5'])): ?> style="top: <?= $movements['wp-5']['y']; ?>px; left: <?= $movements['wp-5']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-pawn" id="wp-6"<?php if(isset($movements['wp-6'])): ?> style="top: <?= $movements['wp-6']['y']; ?>px; left: <?= $movements['wp-6']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-pawn" id="wp-7"<?php if(isset($movements['wp-7'])): ?> style="top: <?= $movements['wp-7']['y']; ?>px; left: <?= $movements['wp-7']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-pawn" id="wp-8"<?php if(isset($movements['wp-8'])): ?> style="top: <?= $movements['wp-8']['y']; ?>px; left: <?= $movements['wp-8']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-rook" id="wt-19"<?php if(isset($movements['wt-19'])): ?> style="top: <?= $movements['wt-19']['y']; ?>px; left: <?= $movements['wt-19']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-rook" id="wt-20"<?php if(isset($movements['wt-20'])): ?> style="top: <?= $movements['wt-20']['y']; ?>px; left: <?= $movements['wt-20']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-knight" id="wc-29"<?php if(isset($movements['wc-29'])): ?> style="top: <?= $movements['wc-29']['y']; ?>px; left: <?= $movements['wc-29']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-knight" id="wc-30"<?php if(isset($movements['wc-30'])): ?> style="top: <?= $movements['wc-30']['y']; ?>px; left: <?= $movements['wc-30']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-bishop" id="wf-39"<?php if(isset($movements['wf-39'])): ?> style="top: <?= $movements['wf-39']['y']; ?>px; left: <?= $movements['wf-39']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-bishop" id="wf-40"<?php if(isset($movements['wf-40'])): ?> style="top: <?= $movements['wf-40']['y']; ?>px; left: <?= $movements['wf-40']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-queen" id="wd-10"<?php if(isset($movements['wd-10'])): ?> style="top: <?= $movements['wd-10']['y']; ?>px; left: <?= $movements['wd-10']['x']; ?>px;"<?php endif; ?>></div>
        <div class="white-king" id="wr-9"<?php if(isset($movements['wr-9'])): ?> style="top: <?= $movements['wr-9']['y']; ?>px; left: <?= $movements['wr-9']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-pawn" id="bp-1"<?php if(isset($movements['bp-1'])): ?> style="top: <?= $movements['bp-1']['y']; ?>px; left: <?= $movements['bp-1']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-pawn" id="bp-2"<?php if(isset($movements['bp-2'])): ?> style="top: <?= $movements['bp-2']['y']; ?>px; left: <?= $movements['bp-2']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-pawn" id="bp-3"<?php if(isset($movements['bp-3'])): ?> style="top: <?= $movements['bp-3']['y']; ?>px; left: <?= $movements['bp-3']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-pawn" id="bp-4"<?php if(isset($movements['bp-4'])): ?> style="top: <?= $movements['bp-4']['y']; ?>px; left: <?= $movements['bp-4']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-pawn" id="bp-5"<?php if(isset($movements['bp-5'])): ?> style="top: <?= $movements['bp-5']['y']; ?>px; left: <?= $movements['bp-5']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-pawn" id="bp-6"<?php if(isset($movements['bp-6'])): ?> style="top: <?= $movements['bp-6']['y']; ?>px; left: <?= $movements['bp-6']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-pawn" id="bp-7"<?php if(isset($movements['bp-7'])): ?> style="top: <?= $movements['bp-7']['y']; ?>px; left: <?= $movements['bp-7']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-pawn" id="bp-8"<?php if(isset($movements['bp-8'])): ?> style="top: <?= $movements['bp-8']['y']; ?>px; left: <?= $movements['bp-8']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-rook" id="bt-19"<?php if(isset($movements['bt-19'])): ?> style="top: <?= $movements['bt-19']['y']; ?>px; left: <?= $movements['bt-19']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-rook" id="bt-20"<?php if(isset($movements['bt-20'])): ?> style="top: <?= $movements['bt-20']['y']; ?>px; left: <?= $movements['bt-20']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-knight" id="bc-29"<?php if(isset($movements['bc-29'])): ?> style="top: <?= $movements['bc-29']['y']; ?>px; left: <?= $movements['bc-29']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-knight" id="bc-30"<?php if(isset($movements['bc-30'])): ?> style="top: <?= $movements['bc-30']['y']; ?>px; left: <?= $movements['bc-39']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-bishop" id="bf-39"<?php if(isset($movements['bf-39'])): ?> style="top: <?= $movements['bf-39']['y']; ?>px; left: <?= $movements['bf-39']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-bishop" id="bf-40"<?php if(isset($movements['bf-40'])): ?> style="top: <?= $movements['bf-40']['y']; ?>px; left: <?= $movements['bf-40']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-queen" id="bd-10"<?php if(isset($movements['bd-10'])): ?> style="top: <?= $movements['bd-10']['y']; ?>px; left: <?= $movements['bd-10']['x']; ?>px;"<?php endif; ?>></div>
        <div class="black-king" id="br-9"<?php if(isset($movements['br-9'])): ?> style="top: <?= $movements['br-9']['y']; ?>px; left: <?= $movements['br-9']['x']; ?>px;"<?php endif; ?>></div>
        <div id="change">
            <div id="white">
                <div class="change-white-bishop"></div>
                <div class="change-white-knight"></div>
                <div class="change-white-rook"></div>
                <div class="change-white-queen"></div>
            </div>
            <div id="black">
                <div class="change-black-bishop"></div>
                <div class="change-black-knight"></div>
                <div class="change-black-rook"></div>
                <div class="change-black-queen"></div>
            </div>
        </div>
    </div>
</div>
