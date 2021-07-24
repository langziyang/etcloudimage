<?php


class Link extends LinkCore
{
    public function getImageLink($name, $ids, $type = null)
    {
        if (is_numeric($ids)) {
            $cloudimage = Configuration::get('ETCLOUDIMAGE_ACCOUNT_DOMAIN');
            return '//' . $cloudimage . '/v7/' . Image::getImgFolderStatic($ids) . $ids . '.jpg?p=' . $type;
        } else {
            return parent::getImageLink($name, $ids, $type);
        }
        return parent::getImageLink($name, $ids, $type);
    }
}