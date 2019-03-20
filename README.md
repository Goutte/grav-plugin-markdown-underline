# Markdown Underline Plugin

Overrides the default behavior to convert double underscore `__` inline blocks to underline `<u>` instead of `<strong>`.

**Use with caution, as underlining makes text harder to read.**

> If you don't think so, please be thankful for your great sight and ortholexia.

Anyways, it's just another tag for your CSS to tinker with, you don't have to underline.

The **Markdown Underline** Plugin is for [Grav CMS](http://github.com/getgrav/grav). Use __double underscore__ create `<u>` tags.

## Installation

Installing the Markdown Underline plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

!! NOT SUBMITTED YET

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install markdown-underline

This will install the Markdown Underline plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/markdown-underline`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `markdown-underline`. You can find these files on [GitHub](https://github.com/goutte/grav-plugin-markdown-underline) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/markdown-underline
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

### Admin Plugin

If you use the admin plugin, you can install directly through the admin plugin by browsing the `Plugins` tab and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/markdown-underline/markdown-underline.yaml` to `user/config/plugins/markdown-underline.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

Note that if you use the admin plugin, a file with your configuration, and named markdown-underline.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.

## Usage

    This will be __underlined text__.

yields

    This will be <u>underlined text</u>.

## Future

- Perhaps evolve into a plugin that allows individual overriding of `*`, `**`, `_`, `__` etc.