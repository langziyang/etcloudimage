<?php


class AdminImagesController extends AdminImagesControllerCore
{
    protected function _regenerateNewImages($dir, $type, $productsImages = false)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $generate_hight_dpi_images = (bool)Configuration::get('PS_HIGHT_DPI');

        if (!$productsImages) {
            $formated_medium = ImageType::getFormattedName('medium');
            foreach (scandir($dir, SCANDIR_SORT_NONE) as $image) {
                if (preg_match('/^[0-9]*\.jpg$/', $image)) {
                    foreach ($type as $k => $imageType) {
                        // Customizable writing dir
                        $newDir = $dir;
                        if (!file_exists($newDir)) {
                            continue;
                        }

                        if (($dir == _PS_CAT_IMG_DIR_) && ($imageType['name'] == $formated_medium) && is_file(_PS_CAT_IMG_DIR_ . str_replace('.', '_thumb.', $image))) {
                            $image = str_replace('.', '_thumb.', $image);
                        }

                        if (!file_exists($newDir . substr($image, 0, -4) . '-' . stripslashes($imageType['name']) . '.jpg')) {
                            if (!file_exists($dir . $image) || !filesize($dir . $image)) {
                                $this->errors[] = $this->trans('Source file does not exist or is empty (%filepath%)', ['%filepath%' => $dir . $image], 'Admin.Design.Notification');
                            } elseif (!ImageManager::resize($dir . $image, $newDir . substr(str_replace('_thumb.', '.', $image), 0, -4) . '-' . stripslashes($imageType['name']) . '.jpg', (int)$imageType['width'], (int)$imageType['height'])) {
                                $this->errors[] = $this->trans('Failed to resize image file (%filepath%)', ['%filepath%' => $dir . $image], 'Admin.Design.Notification');
                            }

                            if ($generate_hight_dpi_images) {
                                if (!ImageManager::resize($dir . $image, $newDir . substr($image, 0, -4) . '-' . stripslashes($imageType['name']) . '2x.jpg', (int)$imageType['width'] * 2, (int)$imageType['height'] * 2)) {
                                    $this->errors[] = $this->trans('Failed to resize image file to high resolution (%filepath%)', ['%filepath%' => $dir . $image], 'Admin.Design.Notification');
                                }
                            }
                        }
                        // stop 4 seconds before the timeout, just enough time to process the end of the page on a slow server
                        if (time() - $this->start_time > $this->max_execution_time - 4) {
                            return 'timeout';
                        }
                    }
                }
            }
        } else {
            foreach (Image::getAllImages() as $image) {
                $imageObj = new Image($image['id_image']);
                $existing_img = $dir . $imageObj->getExistingImgPath() . '.jpg';
                if (file_exists($existing_img) && filesize($existing_img)) {
                } else {
                    $this->errors[] = $this->trans(
                        'Original image is missing or empty (%filename%) for product ID %id%',
                        [
                            '%filename%' => $existing_img,
                            '%id%' => (int)$imageObj->id_product,
                        ],
                        'Admin.Design.Notification'
                    );
                }
                if (time() - $this->start_time > $this->max_execution_time - 4) { // stop 4 seconds before the tiemout, just enough time to process the end of the page on a slow server
                    return 'timeout';
                }
            }
        }

        return (bool)count($this->errors);
    }
}