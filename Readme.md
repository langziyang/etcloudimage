# 赞助作者
![img](http://p.shoucangjie.xin/modules/etcloudimage/wepay.png) ![img](http://p.shoucangjie.xin/modules/etcloudimage/alipay.png)
### 1、Modify  `src/Adapter/Product/ProductDataProvider.php`
Find function name `public function getImage($id_image)`

Change:

    `'base_image_url' => _THEME_PROD_DIR_ . $imageData->getImgPath(),`
to:

`
'base_image_url' => '//' . \Configuration::get('ETCLOUDIMAGE_ACCOUNT_DOMAIN') . '/v7/' . $imageData->getImgPath() . '.jpg?w=98&h=98p=',
`

![img](http://p.shoucangjie.xin/modules/etcloudimage/ProductDataProvider.png)
### 2、Modify `src/Adapter/Image/ImageRetriever.php`
Find function name `public function getImage($object, $id_image)`

Remove

    $resizedImagePath = implode(DIRECTORY_SEPARATOR, [
    $imageFolderPath,

    $id_image . '-' . $image_type['name'] . '.' . $ext,
    ]);
    if (!file_exists($resizedImagePath)) {
        ImageManager::resize(
        $mainImagePath,
        $resizedImagePath,
        (int) $image_type['width'],
        (int) $image_type['height']
        );
    }
![img](http://p.shoucangjie.xin/modules/etcloudimage/ImageRetriever.png)
### 3、Add Origin prefix
![img](http://p.shoucangjie.xin/modules/etcloudimage/domain.png)
### 4、Add image type
![img](http://p.shoucangjie.xin/modules/etcloudimage/presets.png)