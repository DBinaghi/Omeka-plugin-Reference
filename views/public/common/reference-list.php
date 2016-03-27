<?php
if (count($references)):
    // Prepare and display skip links.
    if ($options['skiplinks']):
        // Get the list of headers.
        $letters = array('number' => false) + array_fill_keys(range('A', 'Z'), false);
        foreach ($references as $reference) {
            $first_char = substr($reference, 0, 1);
            if (preg_match('/\W|\d/', $first_char)) {
                $letters['number'] = true;
            }
            else {
                $letters[strtoupper($first_char)] = true;
            }
        }
        $pagination_list = '<ul class="pagination_list">';
        foreach ($letters as $letter => $isSet):
            $letterDisplay = $letter == 'number' ? '#0-9' : $letter;
            if ($isSet) {
                $pagination_list .= sprintf('<li class="pagination_range"><a href="#%s">%s</a></li>', $letter, $letterDisplay);
            }
            else {
                $pagination_list .= sprintf('<li class="pagination_range"><span>%s</span></li>', $letterDisplay);
            }
        endforeach;
        $pagination_list .= '</ul>';
    ?>
<div class="pagination reference-pagination" id="pagination-top">
    <?php echo $pagination_list; ?>
</div>
    <?php endif; ?>

<div id="reference-headings">
    <?php
    $current_heading = '';
    $current_id = '';
    foreach ($references as $reference):
        // Add the first character as header if wanted.
        if ($options['headings']):
            $first_char = substr($reference, 0, 1);
            if (preg_match('/\W|\d/', $first_char)) {
                $first_char = '#0-9';
            }
            $current_first_char = strtoupper($first_char);
            if ($current_heading !== $current_first_char):
                $current_heading = $current_first_char;
                $current_id = $current_heading === '#0-9' ? 'number' : $current_heading; ?>
    <h3 class="reference-heading" id="<?php echo $current_id; ?>"><?php echo $current_heading; ?></h3>
            <?php endif;
        endif; ?>

    <p class="reference-record">
        <?php if (empty($options['raw'])):
            echo '<a href="'
                . url(sprintf('items/browse?advanced[0][element_id]=%s&amp;advanced[0][type]=contains&amp;advanced[0][terms]=%s',
                    $referenceId, urlencode($reference)))
                . '">'
                . $reference
                . '</a>';
        else:
            echo $reference;
        endif; ?>
    </p>
    <?php endforeach; ?>
</div>

    <?php if ($options['skiplinks']): ?>
<div class="pagination reference-pagination" id="pagination-bottom">
    <?php echo $pagination_list; ?>
</div>
    <?php endif;
endif;
