function updateStateDropdown(data) {
    var states = JSON.parse(data.result);

    var stateSelect = $('#country-state select');

    if (stateSelect.length) {
        var emptyOption = stateSelect.find('option:first');

        stateSelect.html('');

        for (var stateId in states) {
            stateSelect.append('<option value="' + stateId + '">' + states[stateId] + '</option>');
        }

        stateSelect.prepend(emptyOption[0].outerHTML);
    }
}