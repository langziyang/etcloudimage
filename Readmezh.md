# 赞助作者
![img](http://p.shoucangjie.xin/modules/etcloudimage/wepay.png) ![img](http://p.shoucangjie.xin/modules/etcloudimage/alipay.png)

### 1、修改文件  `src/Adapter/Product/ProductDataProvider.php`
找到方法名： `public function getImage($id_image)`

修改:

    `'base_image_url' => _THEME_PROD_DIR_ . $imageData->getImgPath(),`
为:

`
'base_image_url' => '//' . \Configuration::get('ETCLOUDIMAGE_ACCOUNT_DOMAIN') . '/v7/' . $imageData->getImgPath() . '.jpg?w=98&h=98p=',
`

![img](http://p.shoucangjie.xin/modules/etcloudimage/ProductDataProvider.png)
### 2、修改文件 `src/Adapter/Image/ImageRetriever.php`

找到方法名 `public function getImage($object, $id_image)`

注释掉：

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
### 3、添加原始连接到CDN
![img](http://p.shoucangjie.xin/modules/etcloudimage/domain.png)

### 4、添加图片大小到CDN，图片大小来自于Prestashop
![img](http://p.shoucangjie.xin/modules/etcloudimage/presets.png)
### 5、删除以前生成的小图片
![img](http://p.shoucangjie.xin/modules/etcloudimage/deleteSmall.png)