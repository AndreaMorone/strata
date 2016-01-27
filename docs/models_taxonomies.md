---
layout: docs
title: Model taxonomies
permalink: /docs/models/taxonomies/
---


## Creating the taxonomy class

To generate a taxonomy definition, you should use the automated generator provided by Strata. It will validate your object's name and ensure it will be correctly defined.

Using the command line, run the `generate` command from your project's base directory. In this example, we will generate a taxonomy called `ProfileType` that will eventually helper categorize a `Profile` model:

~~~ sh
$ ./strata generate taxonomy ProfileType
~~~


## Models with special taxonomy

Should you wish to link a taxonomy to created models you can do so using the `$belongs_to` attribute in the Model's class.

~~~ php
<?php
namespace App\Model;

class Profile extends AppCustomPostType
{

    public $belongs_to = array('App\Model\ProfileType');

    public $configuration = array(
        //...
    );
}
?>
~~~

This will look for a taxonomy definition called `ProfileType`, which can be configured like so :

~~~ php
<?php
namespace App\Model;

use Strata\Model\CustomPostType\Taxonomy;

class ProfileType extends Taxonomy
{
    public $configuration = array(
        'labels'      => array(
            'name' => "Profile Types"
        )
    );
}
?>
~~~

## Additional options

Similarly to the model entities, the optional `$configuration` attribute allows you to customize the configuration array that is sent to `register_taxonomy` internally. As long as you follow the [conventions](http://codex.wordpress.org/Function_Reference/register_taxonomy) your taxonomy will be created using these customized values, filling the missing options with their default counterparts.


## Common concepts

Strata ships with default classes for repeating concepts. These classes help plug in automated queries and enforce similar default behavior.

To gain an object able to query default Wordpress post categories, have your class inherit `Strata\Model\Taxonomy\Taxonomy`:

~~~ php
<?php
namespace App\Model\Taxonomy;

use Strata\Model\Taxonomy\Category as StrataCategory;

class Category extends StrataCategory
{

}
?>
~~~