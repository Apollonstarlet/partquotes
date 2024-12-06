import Decimal from 'decimal.js';

$(() => {
	const calculateSummary = () => {
		let summary = '';

		const quoteConfirmButton = $('#confirm-quote-button');
		quoteConfirmButton.prop('disabled', false);

		let totalItems = new Decimal(0);
		let totalVat = new Decimal(0);
		let totalPrice = new Decimal(0);

		(window.quoteParts || []).map((quotePart, index) => {
			const price = new Decimal($('#price' + index).val() || 0);
			const vat = price.times(new Decimal('0.2'));
			const itemTotal = price.add(vat);

			totalItems = totalItems.plus(price);
			totalVat = totalVat.plus(vat);
			totalPrice = totalPrice.plus(itemTotal);

			$('#price-vat' + index).val(vat.toFixed(2));
			const condition = $('#condition' + index).val();
			const guarantee = $('#guarantee' + index).val();

			const conditionMap = {
				1: 'Used',
				2: 'New',
				3: 'Reconditioned',
				4: 'Remanufactured'
			};

			summary += `
            <tr>
                <td class="text-start">
                  <b> Part #${quotePart.part_id} </b>
                  <br />
                  ${quotePart.part_desc}
                </td>
                <td class="ps-4">${conditionMap[condition] || ''}</td>
                <td class="ps-4">${guarantee || 0} months</td>
                <td class="ps-4">${price.comparedTo(new Decimal(0)) > 0 ? '&#163;' + price.toFixed(2) : 'Not quoted'}</td>
                <td class="ps-4">${price.comparedTo(new Decimal(0)) > 0 ? '&#163;' + vat.toFixed(2) : '-'}</td>
                <td class="ps-4">${price.comparedTo(new Decimal(0)) > 0 ? '&#163;' + itemTotal.toFixed(2) : ''}</td>
            </tr>
        `;
		});

		// Add delivery
		const deliveryPrice = new Decimal($('#delivery').val() || 0);
		const deliveryVat = deliveryPrice.times(new Decimal('0.2'));
		const deliveryTotal = deliveryPrice.add(deliveryVat);

		const finalItems = totalItems.plus(deliveryPrice);
		const finalVat = totalVat.plus(deliveryVat);
		const finalTotal = totalPrice.plus(deliveryTotal);

		$('#delivery-vat').val(deliveryVat.toFixed(2));

		summary += `
          <tr>
                <td class="text-start">Delivery</td>
                <td></td>
                <td></td>
                <td class="ps-4">${deliveryPrice.comparedTo(new Decimal(0)) > 0 ? '&#163;' + deliveryPrice.toFixed(2) : '-'}</td>
                <td class="ps-4">${deliveryVat.comparedTo(new Decimal(0)) > 0 ? '&#163;' + deliveryVat.toFixed(2) : '-'}</td>
                <td class="ps-4">${deliveryTotal.comparedTo(new Decimal(0)) > 0 ? '&#163;' + deliveryTotal.toFixed(2) : '-'}</td>
            </tr>
        `;

		// Add a total line
		summary += `
          <tr>
            <td class="text-start">Total</td>
            <td></td>
            <td></td>
            <td class="ps-4 text-secondary">${finalItems.comparedTo(new Decimal(0)) > 0 ? '&#163;' + finalItems.toFixed(2) : '-'}</td>
            <td class="ps-4 text-secondary">${finalVat.comparedTo(new Decimal(0)) > 0 ? '&#163;' + finalVat.toFixed(2) : '-'}</td>
            <td class="ps-4 text-bolder">${finalTotal.comparedTo(new Decimal(0)) > 0 ? '&#163;' + finalTotal.toFixed(2) : '-'}</td>
          </tr>
        `;

		if (totalItems.comparedTo(new Decimal(0)) === 0) {
			quoteConfirmButton.prop('disabled', true);
			summary = `<tr><td class="ps-4 text-bold" colspan="4">To submit a quote, at least one part must have a price.</td></tr>`;
		}

		$('#quote-summary-body').html(summary);
	};

	$('.changes-summary').on('input change', calculateSummary);
	calculateSummary();
});
