(function($) {
    /* Sign up enable helper */
    $(document).ready(function() {
        $('#colophon .wFormContainer .primaryAction').prop('disabled', false);
    });

    /* Search submit helper */
    $(document).keydown(function(e) {
        if (e.key === 'Enter') {
            var searchSubmit = $('#search-submit');

            if (document.activeElement.id === 'search') {
                e.preventDefault();
                searchSubmit.click();
            }
        }
    });

    /* Mobile trigger helper */
    $(document).on('click', '#mobile-trigger', function() {
        var masthead = $('#masthead');

        masthead.toggleClass('menu-open');
    });

    /* Search records helper */
    $(document).on('submit', '#database-search', function(e) {
        e.preventDefault();

        if ($('body').hasClass('home')) window.location = '/ai-intersections-database/?search=' + encodeURIComponent($(this).find('#search').val());
        else adjustFilters($(this));
    });

    /* Add filters helper */
    $(document).on('change', '.filter-input input', function() {
        adjustFilters($(this));
    });

    /* Filter clear all helper */
    $(document).on('click', '.clear-all', function() {
        if (!$(this).hasClass('main')) {
            $(this).parent().find('input').prop('checked', false).trigger('change');
        }
        else {
            $('.filter-input input:checked').prop('checked', false).trigger('change');
            $('input[id*="filter"]:checked').prop('checked', false).trigger('change');
        }
    });

    /* Copy link helper */
    $(document).on('click', '.share.link', function(e) {
        e.preventDefault();

        $(this).addClass('copied');
        navigator.clipboard.writeText(window.location.href);
    });

    /* Gravity Forms failed validation helper */
    $(document).on('focus', '.gform_wrapper input, .gform_wrapper textarea', function() {
        $(this).closest('.gfield').removeClass('gfield_error');
        $(this).closest('.gfield').find('.validation_message').fadeOut(1);
    });

    /* Update sort records label */
    $(document).on('change', '#sort-records', function() {
        adjustFilters($(this));
    });

    /* Trigger load more records */
    $(document).on('click', '#load-more-records', function(e) {
        e.preventDefault();

        adjustFilters($(this));
    });

    /* Toggle definitions helper */
    $(document).on('click', '#definitions-toggle', function() {
        var definitions = $('.definition input'),
            toggle = '',
            action = $(this).find('span');

        $(this).toggleClass('expanded');

        if ($(this).hasClass('expanded')) {
            definitions.prop('checked', true).trigger('change');
            toggle = 'collapse';
        }
        else {
            definitions.prop('checked', false).trigger('change');
            toggle = 'expand';
        }

        action.text(toggle);
    });

    /* Sign up expand helper */
    $(document).on('focus', '.wFormContainer .hide-toggle', function() {
        $(this).parent().find('.hide').removeClass('hide');
    });

    function adjustFilters(e) {
        var records = parseInt($('.records .async__inner').attr('data-current')),
            filterName = e.next().text(),
            filterParent = e.parent().parent(),
            filters = '',
            types,
            typesParams = '',
            actorTypes,
            actorTypesParams = '',
            justiceAreas,
            justiceAreasParams = '',
            aiImpacts,
            aiImpactsParams = '',
            serviceAreas,
            serviceAreasParams = '',
            regions,
            regionsParams = '',
            years = '',
            yearsParams = '',
            search = searchParams('search'),
            sorted = '',
            queryString = '';

        /* Clear search helper */
        if (e.attr('id') !== 'database-search' && e.attr('id') !== 'sort-records' && e.attr('id') !== 'load-more-records') $('#search').val('');

        /* Select all/global helper */
        if (filterName === 'Select All' || filterName === 'Global') {
            if (e.prop('checked') === true) e.parent().parent().find('input').prop('checked', true);
            else e.parent().parent().find('input').prop('checked', false);
        }

        /* Country/region helper */
        if (e.attr('id').indexOf('service_area') !== -1) {
            if (filterName === 'Global North') {
                var matches = [
                    "Anguilla",
                    "Tuvalu",
                    "Palau",
                    "Kazakhstan",
                    "Kyrgyzstan",
                    "Uzbekistan",
                    "Japan",
                    "Korea, Republic of",
                    "Armenia",
                    "Azerbaijan",
                    "Cyprus",
                    "Georgia",
                    "Israel",
                    "Turkey",
                    "Belarus",
                    "Bulgaria",
                    "Czech Republic",
                    "Hungary",
                    "Moldova, Republic of",
                    "Poland",
                    "Romania",
                    "Russian Federation",
                    "Slovakia",
                    "Ukraine",
                    "Austria",
                    "Belgium",
                    "France",
                    "Germany",
                    "Liechtenstein",
                    "Luxembourg",
                    "Monaco",
                    "Netherlands",
                    "Switzerland",
                    "Åland Islands",
                    "Denmark",
                    "Estonia",
                    "Faroe Islands",
                    "Finland",
                    "Iceland",
                    "Ireland",
                    "Isle of Man",
                    "Latvia",
                    "Lithuania",
                    "Norway",
                    "Svalbard and Jan Mayen",
                    "Sweden",
                    "United Kingdom",
                    "Albania",
                    "Andorra",
                    "Croatia",
                    "Gibraltar",
                    "Greece",
                    "Holy See (Vatican City State)",
                    "Italy",
                    "Macedonia, the Former Yugoslav Republic of",
                    "Malta",
                    "Montenegro",
                    "Portugal",
                    "San Marino",
                    "Serbia",
                    "Slovenia",
                    "Spain",
                    "Bermuda",
                    "Canada",
                    "Greenland",
                    "Saint Pierre and Miquelon",
                    "United States",
                    "Australia",
                    "Christmas Island",
                    "Cocos (Keeling) Islands",
                    "Heard Island and McDonald Islands",
                    "New Zealand",
                    "Norfolk Island",
                    "Guernsey",
                    "Jersey"
                ];

                if (e.prop('checked') === true) {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', true);
                    });
                }
                else {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', false);
                    });
                }
            }
            else if (filterName === 'Global South') {
                var matches = [
                    "Antigua and Barbuda",
                    "Aruba",
                    "Bahamas",
                    "Barbados",
                    "Cayman Islands",
                    "Cuba",
                    "Curaçao",
                    "Dominica",
                    "Dominican Republic",
                    "Grenada",
                    "Guadeloupe",
                    "Haiti",
                    "Jamaica",
                    "Martinique",
                    "Montserrat",
                    "Puerto Rico",
                    "Saint Barthélemy",
                    "Saint Kitts and Nevis",
                    "Saint Lucia",
                    "Saint Martin (French part)",
                    "Saint Vincent and the Grenadines",
                    "Sint Maarten (Dutch part)",
                    "Trinidad and Tobago",
                    "Turks and Caicos Islands",
                    "Virgin Islands, British",
                    "Virgin Islands, U.S.",
                    "Fiji",
                    "New Caledonia",
                    "Papua New Guinea",
                    "Solomon Islands",
                    "Vanuatu",
                    "American Samoa",
                    "Cook Islands",
                    "French Polynesia",
                    "Niue",
                    "Pitcairn",
                    "Samoa",
                    "Tokelau",
                    "Tonga",
                    "Wallis and Futuna",
                    "Guam",
                    "Kiribati",
                    "Marshall Islands",
                    "Micronesia, Federated States of",
                    "Nauru",
                    "Northern Mariana Islands",
                    "United States Minor Outlying Islands",
                    "Antarctica",
                    "Kosovo",
                    "Tajikistan",
                    "Turkmenistan",
                    "China",
                    "Hong Kong",
                    "Korea, Democratic People's Republic of",
                    "Macao",
                    "Mongolia",
                    "Taiwan, Province of China",
                    "Bahrain",
                    "Iraq",
                    "Jordan",
                    "Kuwait",
                    "Lebanon",
                    "Oman",
                    "Palestine, State of",
                    "Qatar",
                    "Saudi Arabia",
                    "Syrian Arab Republic",
                    "United Arab Emirates",
                    "Yemen",
                    "Afghanistan",
                    "Bangladesh",
                    "Bhutan",
                    "India",
                    "Iran, Islamic Republic of",
                    "Maldives",
                    "Nepal",
                    "Pakistan",
                    "Sri Lanka",
                    "Thailand",
                    "Algeria",
                    "Egypt",
                    "Libya",
                    "Morocco",
                    "Sudan",
                    "Tunisia",
                    "Western Sahara",
                    "Bosnia and Herzegovina",
                    "Brunei Darussalam",
                    "Cambodia",
                    "Indonesia",
                    "Lao People's Democratic Republic",
                    "Malaysia",
                    "Myanmar",
                    "Philippines",
                    "Timor-Leste",
                    "Viet Nam",
                    "Singapore",
                    "Swaziland",
                    "Bonaire, Sint Eustatius and Saba",
                    "Angola",
                    "Cameroon",
                    "Central African Republic",
                    "Chad",
                    "Congo",
                    "Congo, the Democratic Republic of the",
                    "Equatorial Guinea",
                    "Gabon",
                    "Sao Tome and Principe",
                    "Argentina",
                    "Bolivia, Plurinational State of",
                    "Bouvet Island",
                    "Brazil",
                    "Chile",
                    "Colombia",
                    "Ecuador",
                    "Falkland Islands (Malvinas)",
                    "French Guiana",
                    "Guyana",
                    "Paraguay",
                    "Peru",
                    "South Georgia and the South Sandwich Islands",
                    "Suriname",
                    "Uruguay",
                    "Venezuela, Bolivarian Republic of",
                    "British Indian Ocean Territory",
                    "Burundi",
                    "Comoros",
                    "Djibouti",
                    "Eritrea",
                    "Ethiopia",
                    "French Southern Territories",
                    "Kenya",
                    "Madagascar",
                    "Malawi",
                    "Mauritius",
                    "Mayotte",
                    "Mozambique",
                    "Réunion",
                    "Rwanda",
                    "Seychelles",
                    "Somalia",
                    "South Sudan",
                    "Tanzania, United Republic of",
                    "Uganda",
                    "Zambia",
                    "Zimbabwe",
                    "Benin",
                    "Burkina Faso",
                    "Cape Verde",
                    "Côte d'Ivoire",
                    "Gambia",
                    "Ghana",
                    "Guinea",
                    "Guinea-Bissau",
                    "Liberia",
                    "Mali",
                    "Mauritania",
                    "Niger",
                    "Nigeria",
                    "Saint Helena, Ascension and Tristan da Cunha",
                    "Senegal",
                    "Sierra Leone",
                    "Togo",
                    "Belize",
                    "Costa Rica",
                    "El Salvador",
                    "Guatemala",
                    "Honduras",
                    "Mexico",
                    "Nicaragua",
                    "Panama",
                    "Botswana",
                    "Lesotho",
                    "Namibia",
                    "South Africa"
                ];

                if (e.prop('checked') === true) {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', true);
                    });
                }
                else {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', false);
                    });
                }
            }
            else if (filterName === 'Africa') {
                var matches = [
                    "Algeria",
                    "Egypt",
                    "Libya",
                    "Morocco",
                    "Sudan",
                    "Tunisia",
                    "Western Sahara",
                    "Singapore",
                    "Swaziland",
                    "Angola",
                    "Cameroon",
                    "Central African Republic",
                    "Chad",
                    "Congo",
                    "Congo, the Democratic Republic of the",
                    "Equatorial Guinea",
                    "Gabon",
                    "Sao Tome and Principe",
                    "British Indian Ocean Territory",
                    "Burundi",
                    "Comoros",
                    "Djibouti",
                    "Eritrea",
                    "Ethiopia",
                    "French Southern Territories",
                    "Kenya",
                    "Madagascar",
                    "Malawi",
                    "Mauritius",
                    "Mayotte",
                    "Mozambique",
                    "Réunion",
                    "Rwanda",
                    "Seychelles",
                    "Somalia",
                    "South Sudan",
                    "Tanzania, United Republic of",
                    "Uganda",
                    "Zambia",
                    "Zimbabwe",
                    "Benin",
                    "Burkina Faso",
                    "Cape Verde",
                    "Côte d'Ivoire",
                    "Gambia",
                    "Ghana",
                    "Guinea",
                    "Guinea-Bissau",
                    "Liberia",
                    "Mali",
                    "Mauritania",
                    "Niger",
                    "Nigeria",
                    "Saint Helena, Ascension and Tristan da Cunha",
                    "Senegal",
                    "Sierra Leone",
                    "Togo",
                    "Botswana",
                    "Lesotho",
                    "Namibia",
                    "South Africa"
                ];
                
                if (e.prop('checked') === true) {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', true);
                    });
                }
                else {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', false);
                    });
                }
            }
            else if (filterName === 'Americas') {
                var matches = [
                    "Anguilla",
                    "Antigua and Barbuda",
                    "Aruba",
                    "Bahamas",
                    "Barbados",
                    "Cayman Islands",
                    "Cuba",
                    "Curaçao",
                    "Dominica",
                    "Dominican Republic",
                    "Grenada",
                    "Guadeloupe",
                    "Haiti",
                    "Jamaica",
                    "Martinique",
                    "Montserrat",
                    "Puerto Rico",
                    "Saint Barthélemy",
                    "Saint Kitts and Nevis",
                    "Saint Lucia",
                    "Saint Martin (French part)",
                    "Saint Vincent and the Grenadines",
                    "Sint Maarten (Dutch part)",
                    "Trinidad and Tobago",
                    "Turks and Caicos Islands",
                    "Virgin Islands, British",
                    "Virgin Islands, U.S.",
                    "Bermuda",
                    "Canada",
                    "Greenland",
                    "Saint Pierre and Miquelon",
                    "United States",
                    "Bonaire, Sint Eustatius and Saba",
                    "Argentina",
                    "Bolivia, Plurinational State of",
                    "Bouvet Island",
                    "Brazil",
                    "Chile",
                    "Colombia",
                    "Ecuador",
                    "Falkland Islands (Malvinas)",
                    "French Guiana",
                    "Guyana",
                    "Paraguay",
                    "Peru",
                    "South Georgia and the South Sandwich Islands",
                    "Suriname",
                    "Uruguay",
                    "Venezuela, Bolivarian Republic of",
                    "Belize",
                    "Costa Rica",
                    "El Salvador",
                    "Guatemala",
                    "Honduras",
                    "Mexico",
                    "Nicaragua",
                    "Panama"
                ];
                
                if (e.prop('checked') === true) {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', true);
                    });
                }
                else {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', false);
                    });
                }
            }
            else if (filterName === 'Asia') {
                var matches = [
                    "Kazakhstan",
                    "Kyrgyzstan",
                    "Tajikistan",
                    "Turkmenistan",
                    "Uzbekistan",
                    "China",
                    "Hong Kong",
                    "Japan",
                    "Korea, Democratic People's Republic of",
                    "Korea, Republic of",
                    "Macao",
                    "Mongolia",
                    "Taiwan, Province of China",
                    "Armenia",
                    "Azerbaijan",
                    "Bahrain",
                    "Cyprus",
                    "Georgia",
                    "Iraq",
                    "Israel",
                    "Jordan",
                    "Kuwait",
                    "Lebanon",
                    "Oman",
                    "Palestine, State of",
                    "Qatar",
                    "Saudi Arabia",
                    "Syrian Arab Republic",
                    "Turkey",
                    "United Arab Emirates",
                    "Yemen",
                    "Afghanistan",
                    "Bangladesh",
                    "Bhutan",
                    "India",
                    "Iran, Islamic Republic of",
                    "Maldives",
                    "Nepal",
                    "Pakistan",
                    "Sri Lanka",
                    "Thailand",
                    "Brunei Darussalam",
                    "Cambodia",
                    "Indonesia",
                    "Lao People's Democratic Republic",
                    "Malaysia",
                    "Myanmar",
                    "Philippines",
                    "Timor-Leste",
                    "Viet Nam"
                ];
                
                if (e.prop('checked') === true) {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', true);
                    });
                }
                else {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', false);
                    });
                }
            }
            else if (filterName === 'Europe') {
                var matches = [
                    "Belarus",
                    "Bulgaria",
                    "Czech Republic",
                    "Hungary",
                    "Moldova, Republic of",
                    "Poland",
                    "Romania",
                    "Russian Federation",
                    "Slovakia",
                    "Ukraine",
                    "Austria",
                    "Belgium",
                    "France",
                    "Germany",
                    "Liechtenstein",
                    "Luxembourg",
                    "Monaco",
                    "Netherlands",
                    "Switzerland",
                    "Åland Islands",
                    "Denmark",
                    "Estonia",
                    "Faroe Islands",
                    "Finland",
                    "Iceland",
                    "Ireland",
                    "Isle of Man",
                    "Latvia",
                    "Lithuania",
                    "Norway",
                    "Svalbard and Jan Mayen",
                    "Sweden",
                    "United Kingdom",
                    "Albania",
                    "Andorra",
                    "Bosnia and Herzegovina",
                    "Croatia",
                    "Gibraltar",
                    "Greece",
                    "Holy See (Vatican City State)",
                    "Italy",
                    "Macedonia, the Former Yugoslav Republic of",
                    "Malta",
                    "Montenegro",
                    "Portugal",
                    "San Marino",
                    "Serbia",
                    "Slovenia",
                    "Spain",
                    "Guernsey",
                    "Jersey"
                ];
                
                if (e.prop('checked') === true) {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', true);
                    });
                }
                else {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', false);
                    });
                }
            }
            else if (filterName === 'Oceania') {
                var matches = [
                    "Fiji",
                    "New Caledonia",
                    "Papua New Guinea",
                    "Solomon Islands",
                    "Vanuatu",
                    "American Samoa",
                    "Cook Islands",
                    "French Polynesia",
                    "Niue",
                    "Pitcairn",
                    "Samoa",
                    "Tokelau",
                    "Tonga",
                    "Tuvalu",
                    "Wallis and Futuna",
                    "Guam",
                    "Kiribati",
                    "Marshall Islands",
                    "Micronesia, Federated States of",
                    "Nauru",
                    "Northern Mariana Islands",
                    "Palau",
                    "United States Minor Outlying Islands",
                    "Australia",
                    "Christmas Island",
                    "Cocos (Keeling) Islands",
                    "Heard Island and McDonald Islands",
                    "New Zealand",
                    "Norfolk Island"
                ];
                
                if (e.prop('checked') === true) {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', true);
                    });
                }
                else {
                    matches.forEach(function(text) {
                        filterParent.find('label:contains("' + text + '")').prev().prop('checked', false);
                    });
                }
            }
        }

        /* Load more records helper */
        if (e.attr('id') === 'load-more-records') records = records + 8;
        else records = 8;

        /* Create filter arrays */
        types = $('.filter-input input[id*="main_type"]:checked').map(function() {
            return this.value;
        }).get();
        typesParams = types.join(',');

        actorTypes = $('.filter-input input[id*="actor_type"]:checked').map(function() {
            return this.value;
        }).get();
        actorTypesParams = actorTypes.join(',');

        justiceAreas = $('.filter-input input[id*="justice_area"]:checked').map(function() {
            return this.value;
        }).get();
        justiceAreasParams = justiceAreas.join(',');

        aiImpacts = $('.filter-input input[id*="ai_impact"]:checked').map(function() {
            return this.value;
        }).get();
        aiImpactsParams = aiImpacts.join(',');

        serviceAreas = $('.filter-input input[id*="service_area"]:checked').map(function() {
            return this.value;
        }).get();
        serviceAreasParams = serviceAreas.join(',');

        regions = $('.filter-input input[id*="region"]:checked').map(function() {
            return this.value;
        }).get();
        regionsParams = regions.join(',');

        years = $('.filter-input input[id*="year"]:checked').map(function() {
            return this.value;
        }).get();
        yearsParams = years.join(',');

        if (e.attr('id') === 'sort-records') sorted = e.val();
        else sorted = $('#database-results #sort-records').val();

        /* Build query string */
        queryString = '?records=' + records + '&sort=' + sorted;

        if (typesParams !== '') queryString += '&type=' + encodeURIComponent(typesParams);
        if (actorTypesParams !== '') queryString += '&actor_type=' + encodeURIComponent(actorTypesParams);
        if (justiceAreasParams !== '') queryString += '&justice_area=' + encodeURIComponent(justiceAreasParams);
        if (aiImpactsParams !== '') queryString += '&ai_impact=' + encodeURIComponent(aiImpactsParams);
        if (serviceAreasParams !== '') queryString += '&service_area=' + encodeURIComponent(serviceAreasParams);
        if (regionsParams !== '') queryString += '&region=' + encodeURIComponent(regionsParams);
        if (yearsParams !== '') queryString += '&service_year=' + encodeURIComponent(yearsParams);

        /* Check status of search parameter */
        if (e.attr('id') === 'database-search') {
            queryString += '&search=' + encodeURIComponent(e.find('#search').val());
        }
        else if (search) {
            if (e.attr('id') === 'sort-records' || e.attr('id') === 'load-more-records') queryString += '&search=' + encodeURIComponent(search);
        }

        /* Display active filters */
        $('.filter-input input').each(function() {
            if ($(this).attr('id').indexOf('all') === -1) {
                if ($(this).prop('checked') === true) {
                    var filterName = $(this).next().text(),
                        filterTrigger = $(this).attr('id');

                    if (filterName === 'type') filterName = 'main-type';
                    if (filters === '') filters = '<div class="filters__inner">';
                    
                    filters += '<label for="' + filterTrigger + '" class="filters__inner__filter">' + filterName + '</label>';
                }
                else {
                    $(this).parent().parent().find('input[id*="all"]').prop('checked', false);
                }
            }
        }).promise().done(function() {
            $('.filters').html(filters + '</div>');
        }).promise().done(function() {
            $('#records').addClass('loading');
            $('#records').load('/ai-intersections-database/' + queryString + ' .async', function() {
                var url = window.location.protocol + '//' + window.location.host + window.location.pathname + queryString;
                
                window.history.pushState({
                    path: url
                }, '', url);

                $('.records .async__inner').attr('data-current', records);
                $('#records').removeClass('loading');
            });
        });
    }

    function searchParams(term) {
        term = term.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');

        var regex = new RegExp('[\\?&]' + term + '=([^&#]*)'),
            results = regex.exec(location.search);
            
        return results === null ? null : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }
})(jQuery);
