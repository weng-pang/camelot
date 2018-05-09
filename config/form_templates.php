<?php
/**
 * Used to customize the output of the FormHelper class (e.g. $this->Form->control('username')).
 * Refer to the documentation at  https://api.cakephp.org/3.6/class-Cake.View.Helper.FormHelper.html#%24_defaultConfig
 * to see which different templates we can configure and examples of what the template should look like.
 */
return [

    /**
     * This hierarchy (i.e. FormTemplates => Admin) is completely arbitrary. I've named it this so that I can
     * refer to it later by going $this->Form->setTemplates(Configure::read('FormTemplates.Admin').
     */
    'FormTemplates' => [
        'Admin' => [

            /**
             * This is the most important bit of this class. This is where I've overridden a series of templates from
             * https://api.cakephp.org/3.6/class-Cake.View.Helper.FormHelper.html#%24_defaultConfig so that they look
             * more like what the "Modular Admin HTML" template (https://github.com/modularcode/modular-admin-html) uses.
             */
            'inputContainer' => '<div class="form-group">{{content}}</div>',
            'label' => '<label class="control-label" {{attrs}}><span>{{text}}</span></label>',
            'input' => '<input type="{{type}}" name="{{name}}" class="form-control underlined" {{attrs}}/>',
            'textarea' => '<textarea name="{{name}}" class="form-control underlined" {{attrs}}>{{value}}</textarea>',

            // The additional "<span>" here is because the "Modular Admin HTML template does some magic with regards to
            // styling checkboxes. It actually hides the real checkbox, and replaces it with a fancy box that it styles
            // itself.
            'checkbox' => '<input type="checkbox" class="checkbox" name="{{name}}" value="{{value}}"{{attrs}}><span></span>',

            'inputSubmit' => '<input type="{{type}}" class="btn btn-block btn-primary" {{atrs}} />',
            'button' => '<button class="btn btn-primary" {{atrs}}>{{text}}</button>',
        ],
    ],
];