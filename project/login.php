<?PHP

// connect to mysql database
$l = mysqli_connect("localhost:6306", "student12", "pass12", "student12");

// query to populate combobox search
$query = "SELECT * FROM Students ORDER BY user_name";
$r = mysqli_query($l, $query);

?>

<html>
    <head>
        <title>Electric Currents Blackboard v2</title>


<!--        <script src="https://www.google.com/recaptcha/api.js" async defer></script>//-->


        <link rel="stylesheet" type="text/css" href='css/style.css'>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>jQuery UI Autocomplete - Combobox</title>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://code.jquery.com/resources/demos/style.css">
    </head>
    <body>
        <h1>Welcome to Electric Currents Blackboard v2!</h1>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function() {
                $.widget("custom.combobox", {
                    _create: function() {
                        this.wrapper = $("<span>")
                            .addClass("custom-combobox")
                            .insertAfter(this.element);

                        this.element.hide();
                        this._createAutocomplete();
                        this._createShowAllButton();
                    },

                    _createAutocomplete: function() {
                        var selected = this.element.children(":selected"),
                            value = selected.val() ? selected.text() : "";

                        this.input = $("<input>")
                            .appendTo(this.wrapper)
                            .val(value)
                            .attr("title", "")
                            .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                            .autocomplete({
                                delay: 0,
                                minLength: 0,
                                source: $.proxy(this, "_source")
                            })
                            .tooltip({
                                classes: {
                                    "ui-tooltip": "ui-state-highlight"
                                }
                            });

                        this._on(this.input, {
                            autocompleteselect: function(event, ui) {
                                ui.item.option.selected = true;
                                this._trigger("select", event, {
                                    item: ui.item.option
                                });
                            },

                            autocompletechange: "_removeIfInvalid"
                        });
                    },

                    _createShowAllButton: function() {
                        var input = this.input,
                            wasOpen = false;

                        $("<a>")
                            .attr("tabIndex", -1)
                            .attr("title", "Show All Items")
                            .tooltip()
                            .appendTo(this.wrapper)
                            .button({
                                icons: {
                                    primary: "ui-icon-triangle-1-s"
                                },
                                text: false
                            })
                            .removeClass("ui-corner-all")
                            .addClass("custom-combobox-toggle ui-corner-right")
                            .on("mousedown", function() {
                                wasOpen = input.autocomplete("widget").is(":visible");
                            })
                            .on("click", function() {
                                input.trigger("focus");

                                // Close if already visible
                                if (wasOpen) {
                                    return;
                                }

                                // Pass empty string as value to search for, displaying all results
                                input.autocomplete("search", "");
                            });
                    },

                    _source: function(request, response) {
                        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                        response(this.element.children("option").map(function() {
                            var text = $(this).text();
                            if (this.value && (!request.term || matcher.test(text)))
                                return {
                                    label: text,
                                    value: text,
                                    option: this
                                };
                        }));
                    },

                    _removeIfInvalid: function(event, ui) {

                        // Selected an item, nothing to do
                        if (ui.item) {
                            return;
                        }

                        // Search for a match (case-insensitive)
                        var value = this.input.val(),
                            valueLowerCase = value.toLowerCase(),
                            valid = false;
                        this.element.children("option").each(function() {
                            if ($(this).text().toLowerCase() === valueLowerCase) {
                                this.selected = valid = true;
                                return false;
                            }
                        });

                        // Found a match, nothing to do
                        if (valid) {
                            return;
                        }

                        // Remove invalid value
                        this.input
                            .val("")
                            .attr("title", value + " didn't match any item")
                            .tooltip("open");
                        this.element.val("");
                        this._delay(function() {
                            this.input.tooltip("close").attr("title", "");
                        }, 2500);
                        this.input.autocomplete("instance").term = "";
                    },

                    _destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                    }
                });

                $("#combobox").combobox();
                $("#toggle").on("click", function() {
                $("#combobox").toggle();
                });
            });
        </script>
        <div>
            <form action=verify.php method=POST align="center">

                <label>Select Your Username:</label>
                <div class="ui-widget">
                    <select id=combobox name=username class='text_field'>
                        <?PHP

                        while ($row = mysqli_fetch_array($r)) {
                            echo "<option>$row[user_name]</option>";
                        }

                        ?>
                    </select>
                </div><br/>
                <div>
                    <label>Enter Your Password:</label><br/>
                    <input type="password" name="password" class='text_field' />
                </div>
                <div><br/>
                    <input type="image" src="images/login.png" alt="Submit Form" />
                </div>
            </form>


<!--            <div class="captcha_wrapper" align="center">
                <div class="g-recaptcha" data-sitekey="6LdmXVkUAAAAAL6oXIviJyI6e6wdW0sUdMJw3eTq"></div>
            </div>//-->


        </div>
    </body>
</html>