
<table>
    <colgroup>
        <col width="*" />
        <col width="24%" />
        <col width="20%" />
        <col width="20%" />
        <col width="20%" />
    </colgroup>
    <thead>
        <tr>
            <th>거래소</th>
            <th>시세(KRW)</th>
            <th>한국프리미엄</th>
            <th>거래금액</th>
            <th>변동률(24h)</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i = 0;
            foreach($exchange as $thisExchange){
                $thisPrice = $data[$i];
                $volume = element('volume', $thisPrice);
                $price = $money == 'usd' ? element('price_usd', $thisPrice) : element('price', $thisPrice);
                $korea_premium = element('korea_premium', $thisPrice);
                $change_rate = element('change_rate', $thisPrice);
                $percent_class = $change_rate > 0 ? 'up' : $change_rate < 0 ? 'down' : '';
        ?>
            <tr>
                <td>
                    <div class="vlogo">
                        <p class="img"><img
                                src="<?php echo element('cme_logo', $thisExchange); ?>" alt="<?php echo element('cme_korean_nm', $thisExchange); ?> 로고" />
                        </p>
                        <p class="txt"><?php echo element('cme_korean_nm', $thisExchange); ?></p>
                    </div>
                </td>
                <td><?php echo rs_get_price($price, $money); ?></td>
                <td><?php echo rs_number_format($korea_premium, 2) ? rs_number_format($korea_premium, 2).' %' : '-'; ?></td>
                <td><?php echo number_unit_to_korean($volume); ?></td>
                <td>
                    <p class="percent <?php echo $percent_class; ?>"><span><?php echo rs_number_format($change_rate,2, 0); ?> %</span></p>
                </td>
            </tr>
        <?php
                $i++;
            }
        ?>
    </tbody>
</table>