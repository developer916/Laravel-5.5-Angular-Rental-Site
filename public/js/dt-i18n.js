(function (window, $) {
    'use strict';
    function define_dtTableHeaders() {
        var dtTableHeaders = {};
        if ($.cookie('lang') == '"nl"') {
            var dtTableHeaders = {
                processing: "Loading...",
                search: "Zoeken&nbsp;:",
                lengthMenu: "Toon _MENU_ voorwerpen",
                info: "Toont _START_ tot _END_ uit _TOTAL_ voorwerpen",
                infoEmpty: "Toont 0 tot 0 uit 0 voorwerpen",
                infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                infoPostFix: "",
                loadingRecords: "Loading items...",
                zeroRecords: "Geen data beschikbaar",
                emptyTable: "Geen data beschikbaar",
                paginate: {
                    first: "",
                    previous: "Vorige",
                    next: "Volgende",
                    last: ""
                },
                aria: {
                    sortAscending: ": ",
                    sortDescending: ": "
                }
            };
        }
        return dtTableHeaders;
    }

    if (typeof(dtTableHeaders) === 'undefined') {
        window.dtTableHeaders = define_dtTableHeaders();
    }
})(window, jQuery);
