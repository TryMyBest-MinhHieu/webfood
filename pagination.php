<div style="display:inline-flex; margin-inline:auto; ">

    <?php 
        if($current_page > 3) {
            $first_page = 1;
            ?>
            <a style="font-size: 18px; border:2px solid black; padding:7px; color:black; margin-inline: 3px;" 
            href="?per_page=<?=$item_per_page?>&page=<?=$first_page?>">First</a>
    <?php
        }
        if($current_page > 1) {
            $prev_page = $current_page - 1;
            ?>
            <a style="font-size: 18px; border:2px solid black; padding:7px; color:black; margin-inline: 3px;" 
            href="?per_page=<?=$item_per_page?>&page=<?=$prev_page?>">Prev</a>
    <?php }
    ?>
    <?php for($num = 1; $num <=$totalPages; $num++) { ?>
        <?php if ($num != $current_page) { ?>
            <?php if ($num > $current_page - 3 && $num < $current_page + 3 ) {?>
                <a style="font-size: 18px; border:2px solid black; padding:7px; color:black; margin-inline: 3px;" 
                href="?per_page=<?=$item_per_page?>&page=<?=$num?>"><?=$num?></a>
            <?php } ?>
        <?php } else { ?>
            <strong style="font-size: 18px; border:2px solid black; padding:7px; color:black; margin-inline: 3px; background-color:yellow"
            ><?= $num ?></strong>
        <?php } ?>
    <?php } ?>
    <?php
    if($current_page < $totalPages - 1){
        $next_page = $current_page + 1; ?>
         <a style="font-size: 18px; border:2px solid black; padding:7px; color:black; margin-inline: 3px;" 
            href="?per_page=<?=$item_per_page?>&page=<?=$next_page?>">Next</a>
    <?php }
    if ($current_page < $totalPages -3 ){
        $end_page = $totalPages;
        ?>
         <a style="font-size: 18px; border:2px solid black; padding:7px; color:black; margin-inline: 3px;" 
            href="?per_page=<?=$item_per_page?>&page=<?=$end_page?>">Last</a>
        <?php
    }
    ?>
    

</div> 





