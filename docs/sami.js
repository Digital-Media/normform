
window.projectVersion = 'master';

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:Fhooe" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Fhooe.html">Fhooe</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Fhooe_NormForm" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Fhooe/NormForm.html">NormForm</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Fhooe_NormForm_Core" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Fhooe/NormForm/Core.html">Core</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Fhooe_NormForm_Core_AbstractNormForm" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Fhooe/NormForm/Core/AbstractNormForm.html">AbstractNormForm</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Fhooe_NormForm_Parameter" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Fhooe/NormForm/Parameter.html">Parameter</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Fhooe_NormForm_Parameter_GenericParameter" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Fhooe/NormForm/Parameter/GenericParameter.html">GenericParameter</a>                    </div>                </li>                            <li data-name="class:Fhooe_NormForm_Parameter_ParameterInterface" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Fhooe/NormForm/Parameter/ParameterInterface.html">ParameterInterface</a>                    </div>                </li>                            <li data-name="class:Fhooe_NormForm_Parameter_PostParameter" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Fhooe/NormForm/Parameter/PostParameter.html">PostParameter</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="namespace:Fhooe_NormForm_View" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Fhooe/NormForm/View.html">View</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Fhooe_NormForm_View_View" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="Fhooe/NormForm/View/View.html">View</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Fhooe.html", "name": "Fhooe", "doc": "Namespace Fhooe"},{"type": "Namespace", "link": "Fhooe/NormForm.html", "name": "Fhooe\\NormForm", "doc": "Namespace Fhooe\\NormForm"},{"type": "Namespace", "link": "Fhooe/NormForm/Core.html", "name": "Fhooe\\NormForm\\Core", "doc": "Namespace Fhooe\\NormForm\\Core"},{"type": "Namespace", "link": "Fhooe/NormForm/Parameter.html", "name": "Fhooe\\NormForm\\Parameter", "doc": "Namespace Fhooe\\NormForm\\Parameter"},{"type": "Namespace", "link": "Fhooe/NormForm/View.html", "name": "Fhooe\\NormForm\\View", "doc": "Namespace Fhooe\\NormForm\\View"},
            {"type": "Interface", "fromName": "Fhooe\\NormForm\\Parameter", "fromLink": "Fhooe/NormForm/Parameter.html", "link": "Fhooe/NormForm/Parameter/ParameterInterface.html", "name": "Fhooe\\NormForm\\Parameter\\ParameterInterface", "doc": "&quot;Defines an interface for parameters that are passed on to a View object.&quot;"},
                                                        {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\ParameterInterface", "fromLink": "Fhooe/NormForm/Parameter/ParameterInterface.html", "link": "Fhooe/NormForm/Parameter/ParameterInterface.html#method_getName", "name": "Fhooe\\NormForm\\Parameter\\ParameterInterface::getName", "doc": "&quot;Returns the name of the parameter. This is always a string.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\ParameterInterface", "fromLink": "Fhooe/NormForm/Parameter/ParameterInterface.html", "link": "Fhooe/NormForm/Parameter/ParameterInterface.html#method_getValue", "name": "Fhooe\\NormForm\\Parameter\\ParameterInterface::getValue", "doc": "&quot;Returns the value of the parameter. Can be any data type.&quot;"},
            
            
            {"type": "Class", "fromName": "Fhooe\\NormForm\\Core", "fromLink": "Fhooe/NormForm/Core.html", "link": "Fhooe/NormForm/Core/AbstractNormForm.html", "name": "Fhooe\\NormForm\\Core\\AbstractNormForm", "doc": "&quot;NormFom is a simple template application to gather, validate and process form data in a flexible way.&quot;"},
                                                        {"type": "Method", "fromName": "Fhooe\\NormForm\\Core\\AbstractNormForm", "fromLink": "Fhooe/NormForm/Core/AbstractNormForm.html", "link": "Fhooe/NormForm/Core/AbstractNormForm.html#method_isValid", "name": "Fhooe\\NormForm\\Core\\AbstractNormForm::isValid", "doc": "&quot;Abstract method used to validate the form input. Must be implemented in the subclass.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Core\\AbstractNormForm", "fromLink": "Fhooe/NormForm/Core/AbstractNormForm.html", "link": "Fhooe/NormForm/Core/AbstractNormForm.html#method_business", "name": "Fhooe\\NormForm\\Core\\AbstractNormForm::business", "doc": "&quot;Abstract method for processing the validated form input (a.k.a. business logic). Must be implemented in the\nsubclass.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Core\\AbstractNormForm", "fromLink": "Fhooe/NormForm/Core/AbstractNormForm.html", "link": "Fhooe/NormForm/Core/AbstractNormForm.html#method___construct", "name": "Fhooe\\NormForm\\Core\\AbstractNormForm::__construct", "doc": "&quot;Creates a new instance for a norm form object and initializes all necessary fields. A View object is used to\ninitially define how and where output is displayed via the template engine and supply parameters to the template.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Core\\AbstractNormForm", "fromLink": "Fhooe/NormForm/Core/AbstractNormForm.html", "link": "Fhooe/NormForm/Core/AbstractNormForm.html#method_normForm", "name": "Fhooe\\NormForm\\Core\\AbstractNormForm::normForm", "doc": "&quot;Main \&quot;decision\&quot; method for the form processing. This decision tree uses isFormSubmission() to check if the form\nis being initially displayed or shown again after a form submission and either calls show() to display the form\n(using the supplied View object) or validate the received input in isValid(). If validation failed, show() is\ncalled again. Possible error messages provided as parameters to the View object in isValid() can now be\ndisplayed. Once the submission was correct, business() is called where the data can be processed as needed.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Core\\AbstractNormForm", "fromLink": "Fhooe/NormForm/Core/AbstractNormForm.html", "link": "Fhooe/NormForm/Core/AbstractNormForm.html#method_isFormSubmission", "name": "Fhooe\\NormForm\\Core\\AbstractNormForm::isFormSubmission", "doc": "&quot;Checks if the current request was an initial one (thus using GET) or a recurring one after a form submission\n(where POST was used).&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Core\\AbstractNormForm", "fromLink": "Fhooe/NormForm/Core/AbstractNormForm.html", "link": "Fhooe/NormForm/Core/AbstractNormForm.html#method_show", "name": "Fhooe\\NormForm\\Core\\AbstractNormForm::show", "doc": "&quot;Used to display output. The currently used object of type View is used to display the content by calling\nthe display() method. Depending on the type of View object, a certain template engine will be used to\nrender the output. The view object will handle passing on the parameters to the template engine.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Core\\AbstractNormForm", "fromLink": "Fhooe/NormForm/Core/AbstractNormForm.html", "link": "Fhooe/NormForm/Core/AbstractNormForm.html#method_isEmptyPostField", "name": "Fhooe\\NormForm\\Core\\AbstractNormForm::isEmptyPostField", "doc": "&quot;Convenience method to check if a form field is empty, thus contains only an empty string. This is preferred to\nPHP&#039;s own empty() method which also defines inputs such as \&quot;0\&quot; as empty.&quot;"},
            
            {"type": "Class", "fromName": "Fhooe\\NormForm\\Parameter", "fromLink": "Fhooe/NormForm/Parameter.html", "link": "Fhooe/NormForm/Parameter/GenericParameter.html", "name": "Fhooe\\NormForm\\Parameter\\GenericParameter", "doc": "&quot;A generic name\/value parameter.&quot;"},
                                                        {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\GenericParameter", "fromLink": "Fhooe/NormForm/Parameter/GenericParameter.html", "link": "Fhooe/NormForm/Parameter/GenericParameter.html#method___construct", "name": "Fhooe\\NormForm\\Parameter\\GenericParameter::__construct", "doc": "&quot;Creates a new parameter using the supplied name and value.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\GenericParameter", "fromLink": "Fhooe/NormForm/Parameter/GenericParameter.html", "link": "Fhooe/NormForm/Parameter/GenericParameter.html#method_getName", "name": "Fhooe\\NormForm\\Parameter\\GenericParameter::getName", "doc": "&quot;Returns the parameter&#039;s name. Always a string.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\GenericParameter", "fromLink": "Fhooe/NormForm/Parameter/GenericParameter.html", "link": "Fhooe/NormForm/Parameter/GenericParameter.html#method_getValue", "name": "Fhooe\\NormForm\\Parameter\\GenericParameter::getValue", "doc": "&quot;Returns the parameter&#039;s value. Can be any data type.&quot;"},
            
            {"type": "Class", "fromName": "Fhooe\\NormForm\\Parameter", "fromLink": "Fhooe/NormForm/Parameter.html", "link": "Fhooe/NormForm/Parameter/ParameterInterface.html", "name": "Fhooe\\NormForm\\Parameter\\ParameterInterface", "doc": "&quot;Defines an interface for parameters that are passed on to a View object.&quot;"},
                                                        {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\ParameterInterface", "fromLink": "Fhooe/NormForm/Parameter/ParameterInterface.html", "link": "Fhooe/NormForm/Parameter/ParameterInterface.html#method_getName", "name": "Fhooe\\NormForm\\Parameter\\ParameterInterface::getName", "doc": "&quot;Returns the name of the parameter. This is always a string.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\ParameterInterface", "fromLink": "Fhooe/NormForm/Parameter/ParameterInterface.html", "link": "Fhooe/NormForm/Parameter/ParameterInterface.html#method_getValue", "name": "Fhooe\\NormForm\\Parameter\\ParameterInterface::getValue", "doc": "&quot;Returns the value of the parameter. Can be any data type.&quot;"},
            
            {"type": "Class", "fromName": "Fhooe\\NormForm\\Parameter", "fromLink": "Fhooe/NormForm/Parameter.html", "link": "Fhooe/NormForm/Parameter/PostParameter.html", "name": "Fhooe\\NormForm\\Parameter\\PostParameter", "doc": "&quot;A special parameter that represents an entry in the $_POST superglobal.&quot;"},
                                                        {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\PostParameter", "fromLink": "Fhooe/NormForm/Parameter/PostParameter.html", "link": "Fhooe/NormForm/Parameter/PostParameter.html#method___construct", "name": "Fhooe\\NormForm\\Parameter\\PostParameter::__construct", "doc": "&quot;Creates a new parameter for the form field\/$_POST entry with the name specified in $postName.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\PostParameter", "fromLink": "Fhooe/NormForm/Parameter/PostParameter.html", "link": "Fhooe/NormForm/Parameter/PostParameter.html#method_updateValue", "name": "Fhooe\\NormForm\\Parameter\\PostParameter::updateValue", "doc": "&quot;Private method for updating the parameter&#039;s value. Checks if there is an entry in the $_POST superglobal.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\PostParameter", "fromLink": "Fhooe/NormForm/Parameter/PostParameter.html", "link": "Fhooe/NormForm/Parameter/PostParameter.html#method_getName", "name": "Fhooe\\NormForm\\Parameter\\PostParameter::getName", "doc": "&quot;Returns the parameter&#039;s name. Always a string.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\Parameter\\PostParameter", "fromLink": "Fhooe/NormForm/Parameter/PostParameter.html", "link": "Fhooe/NormForm/Parameter/PostParameter.html#method_getValue", "name": "Fhooe\\NormForm\\Parameter\\PostParameter::getValue", "doc": "&quot;Updates the parameters value and then returns it. Always a string since it&#039;s form field data.&quot;"},
            
            {"type": "Class", "fromName": "Fhooe\\NormForm\\View", "fromLink": "Fhooe/NormForm/View.html", "link": "Fhooe/NormForm/View/View.html", "name": "Fhooe\\NormForm\\View\\View", "doc": "&quot;Encapsulates data for displaying a form or result of a form submission and uses the Twig template engine to render\nits output.&quot;"},
                                                        {"type": "Method", "fromName": "Fhooe\\NormForm\\View\\View", "fromLink": "Fhooe/NormForm/View/View.html", "link": "Fhooe/NormForm/View/View.html#method___construct", "name": "Fhooe\\NormForm\\View\\View::__construct", "doc": "&quot;Creates a new view with the main template to be displayed, the path to the template and compiled templates\ndirectory as well as parameters of the form. Also initializes the Twig template engine with caching and auto\nreload enabled.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\View\\View", "fromLink": "Fhooe/NormForm/View/View.html", "link": "Fhooe/NormForm/View/View.html#method_getTemplateName", "name": "Fhooe\\NormForm\\View\\View::getTemplateName", "doc": "&quot;Returns the name of the main template that&#039;s being used for display.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\View\\View", "fromLink": "Fhooe/NormForm/View/View.html", "link": "Fhooe/NormForm/View/View.html#method_getParameters", "name": "Fhooe\\NormForm\\View\\View::getParameters", "doc": "&quot;Returns the supplied parameters.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\View\\View", "fromLink": "Fhooe/NormForm/View/View.html", "link": "Fhooe/NormForm/View/View.html#method_setParameter", "name": "Fhooe\\NormForm\\View\\View::setParameter", "doc": "&quot;Allows to add or redefine parameters when the view object already exists. This avoids having to create a\ncompletely new view object just because one parameter has changed or needs to be added. This method first checks\nif a parameter with the given name is already stored within the view. If so, it updates its value with the one\nsupplied in $param. If the parameter is not present in the view, it is being added.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\View\\View", "fromLink": "Fhooe/NormForm/View/View.html", "link": "Fhooe/NormForm/View/View.html#method_display", "name": "Fhooe\\NormForm\\View\\View::display", "doc": "&quot;Displays the current view. Iterates over all the parameters and stores them in a temporary, associative array.&quot;"},
                    {"type": "Method", "fromName": "Fhooe\\NormForm\\View\\View", "fromLink": "Fhooe/NormForm/View/View.html", "link": "Fhooe/NormForm/View/View.html#method_redirectTo", "name": "Fhooe\\NormForm\\View\\View::redirectTo", "doc": "&quot;Performs a generic redirect using header(). GET-Parameters may optionally be supplied as an associative array.&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


