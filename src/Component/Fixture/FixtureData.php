<?php

/*
 * This file is part of the `src-run/serferals` project.
 *
 * (c) Rob Frawley 2nd <rmf@src.run>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SR\Serferals\Component\Fixture;

use SR\Primitive\FileInfo;
use SR\Serferals\Component\ObjectBehavior\FactoryAwareObjectTrait;
use SR\Serferals\Component\ObjectBehavior\IntrospectionAwareObjectTrait;
use SR\Serferals\Component\ObjectBehavior\PropertiesResettableObjectTrait;
use SR\Serferals\Component\ObjectBehavior\SerializableObjectTrait;

/**
 * Class FixtureData.
 */
class FixtureData implements \Serializable
{
    use FactoryAwareObjectTrait;
    use IntrospectionAwareObjectTrait;
    use PropertiesResettableObjectTrait;
    use SerializableObjectTrait;

    /**
     * @var FileInfo
     */
    protected $file;

    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var int|null
     */
    protected $year;

    /**
     * @var null|int
     */
    protected $fileSize;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @return string[]
     */
    public function getFieldsStatic()
    {
        return [
            'file' => 'File Path',
        ];
    }

    /**
     * @return string[]
     */
    public function getFieldsEditable()
    {
        return [
            'enabled' => 'Enabled',
            'name' => 'Name',
            'year' => 'Year',
        ];
    }

    /**
     * @param bool $enabled
     */
    final public function __construct($enabled = false)
    {
        $this->resetState($enabled);
    }

    /**
     * @param FileInfo $file
     * @param string   $name
     * @param bool     $enabled
     *
     * @return $this
     */
    public static function create(FileInfo $file, $name = null, $enabled = false)
    {
        $instance = static::newInstance($enabled)
            ->setFile($file)
            ->setName($name);

        return $instance;
    }

    /**
     * @return $this
     */
    public function resetState($enabled = false)
    {
        $this->propertiesToNull();
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasId()
    {
        return $this->id !== null;
    }

    /**
     * @return FileInfo
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param FileInfo $file
     *
     * @return $this
     */
    public function setFile(FileInfo $file)
    {
        $this->file = clone $file;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int|null $year
     *
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = (int) $year;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasYear()
    {
        return $this->year !== null;
    }

    /**
     * @return int|null
     */
    public function getFileSize()
    {
        return $this->file->getSize();
    }

    /**
     * @return bool
     */
    public function getEnabled()
    {
        return $this->isEnabled();
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool) $enabled;

        return $this;
    }

    /**
     * @param mixed  $value
     * @param string $name
     *
     * @return string
     */
    protected function dataHibernateVisitor($value, $name)
    {
        if ($value instanceof FileInfo) {
            return [$value->getPathname(), $value->getRelativePath(), $value->getRelativePathname()];
        }

        return $value;
    }

    /**
     * @param mixed  $value
     * @param string $name
     *
     * @return string
     */
    protected function dataHydrateVisitor($value, $name)
    {
        if ($name === 'file' && count($value) === 3) {
            return new FileInfo(...$value);
        }

        return $value;
    }
}

/* EOF */
