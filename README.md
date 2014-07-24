# Makundi

## Description

Makundi is an enhancement to the Joomla! categories. The main differences are:

* Translatability.
* Full integration with our CCK.
* Multi-parent categories through taxonomies

Makundi was developed by [Moyo Web Architects](http://moyoweb.nl).

## Requirements

* Joomla 3.X . Untested in Joomla 2.5.
* Koowa 0.9 or 1.0 (as yet, Koowa 2 is not supported)
* PHP 5.3.10 or better
* Composer
* Moyo Components
    * com_cck
    * com_moyo
    * com_articles
    * com_cloudinary
    * com_translations

## Installation

### Composer

Installation is done through composer. In your `composer.json` file, you should add the following lines to the repositories
section:

```json
{
    "name": "moyo/categories",
    "type": "vcs",
    "url": "https://git.assembla.com/moyo-content.categories.git"
}
```

The require section should contain the following line:

```json
    "moyo/categories": "1.0.*",
```

Afterward, just run `composer update` from the root of your Joomla project.

### jsymlinker

Another option, currently only available for Moyo developers, is by using the jsymlink script from the [Moyo Git
Tools](https://github.com/derjoachim/moyo-git-tools).

## How to use - administrator

Makundi is written for the content manager and is intended to entirely replace com_categories. There are two views: the
plural view that is not unlike the stock categories version. However, a number of new fields are visible. The most
important of these is Translations, that lists all translated version of a Makundi item.

The singular view contains a number of familiar items. A short overview of non-familiar items are listed below:

* **Parent Category** A user can select more parent categories if one desires to.
* **Order by** Sets the field to order by on the frontend, e.g. date_published, title, creation_date.
* **Direction** Toggles between ascending and descending.
* **Fieldset** Assigns a default fieldset to each new article within the category
* **Translated** A content editor can edit the translation status of a category

A CCK fieldset is assigned to Makundi items, since each customer wishes to show different elements in the category view.

## Frontend

A makundi view is configured by creating or editing a menu item. The type should be Categories >> Makundi .
