# Introduction <a id="module-openclipart-introduction"></a>

This module allows to query random images for entered search terms. It also allows  
to download those images and use them as icons in other Icinga Web 2 modules.

## Search for random images <a id="module-openclipart-search"></a>

Open the `Random Image`-Chapter 

![Random image](img/openclipart_01.png)

In the following you see the form to search for random images.  
You can search for terms and filter if you want to see nsfw content or not.

![Form](img/openclipart_02.png)

After the search the image and a link to download will appear. The link will take you  
to the download form.

![Result](img/openclipart_03.png)

## Download images <a id="module-openclipart-download"></a>

Following you see the form to download the image.  
The first field is the path relative to  
`/usr/share/icingaweb2/modules/openclipart/public/img/openclipart/`.  
The second one is for the filename. `.svg` extension is appended automatically.

![Download form empty](img/openclipart_04.png)

Here is an example how to fill the fields.

![Download form full](img/openclipart_05.png)

The example is stored as follows.

![Saved image](img/openclipart_06.png)

## Use images as icons <a id="module-openclipart-icons"></a>

After the images is downloaded you can use it as an icon for sections and section subpoints.

First you have to open the module configuration. (In this case vim is used as editor, but you can use whatever you prefer)

```
vim /usr/share/icingaweb2/modules/[MODULE_DIR]/configuration.php
```

Then you can add a new subpoint to the section. The example shows how to change the icon for the Openclipart module.

```
$section = $this->menuSection('Openclipart');
$section->setIcon('img/openclipart/scissors.png');
```