<?php

namespace Imgur\Api;

/**
 * CRUD for Images.
 *
 * @link https://api.imgur.com/endpoints/image
 *
 * @author Adrian Ghiuta <adrian.ghiuta@gmail.com>
 */
class Image extends AbstractApi
{
    /**
     * Upload a new image.
     *
     * @param array $data
     *
     * @link https://api.imgur.com/endpoints/image#image-upload
     *
     * @return bool
     */
    public function upload($data)
    {
        if ($data['type'] === 'file') {
            $data['image'] = '@' . $data['image'];
        }

        return $this->post('image', $data);
    }

    /**
     * Get information about an image.
     *
     * @param string $imageId
     *
     * @link https://api.imgur.com/endpoints/image#image
     *
     * @return array (@see https://api.imgur.com/models/image)
     */
    public function image($imageId)
    {
        return $this->get('image/' . $imageId);
    }

    /**
     * Deletes an image. For an anonymous image, $imageIdOrDeleteHash must be the image's deletehash.
     * If the image belongs to your account then passing the ID of the image is sufficient.
     *
     * @param string $imageIdOrDeleteHash
     *
     * @link https://api.imgur.com/endpoints/image#image-delete
     *
     * @return bool
     */
    public function deleteImage($imageIdOrDeleteHash)
    {
        return $this->delete('image/' . $imageIdOrDeleteHash);
    }

    /**
     * Updates the title or description of an image.
     * You can only update an image you own and is associated with your account.
     * For an anonymous image, {id} must be the image's deletehash.
     *
     * @param string $imageIdOrDeleteHash
     * @param array  $data
     *
     * @link https://api.imgur.com/endpoints/image#image-update
     *
     * @return bool
     */
    public function update($imageIdOrDeleteHash, $data)
    {
        return $this->post('image/' . $imageIdOrDeleteHash, $data);
    }

    /**
     * Favorite an image with the given ID. The user is required to be logged in to favorite the image.
     *
     * @param string $imageIdOrDeleteHash
     *
     * @link https://api.imgur.com/endpoints/image#image-favorite
     *
     * @return bool
     */
    public function favorite($imageIdOrDeleteHash)
    {
        return $this->post('image/' . $imageIdOrDeleteHash . '/favorite');
    }
}
