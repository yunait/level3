<?php
/*
 * This file is part of the Level3 package.
 *
 * (c) Máximo Cuadros <maximo@yunait.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Level3;

use Level3\Resource\Link;
use Level3\Resource\Parameters;
use Level3\Resource\Formatter\Formatter;

class Resource
{
    protected $repository;
    protected $formatter;

    protected $resources = array();
    protected $links = array();
    protected $data;
    protected $parameters;


    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function addLink($rel, Link $link)
    {
        $this->links[$rel][] = $link;

        return $this;
    }

    public function linkResource($rel, Resource $resource)
    {
        $this->addLink($rel, $resource->getSelfLink());

        return $this;
    }

    public function getLinks()
    {
        return $this->links;
    }

    public function addResource($rel, Resource $resource)
    {
        $this->resources[$rel][] = $resource;

        return $this;
    }

    public function getResources()
    {
        return $this->resources;
    }

    public function setData(Array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setParameters(Parameters $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getURI($method = 'GET')
    {
        return $this->repository->getResourceURI($this, $method);
    } 

    public function getSelfLink()
    {
        return new Link($this->getURI());
    }

    public function setFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }

    public function format()
    {
        if (!$this->formatter) {
            return null;
        }

        return $this->formatter->format($this);
    }

    public function formatPretty()
    {
        if (!$this->formatter) {
            return null;
        }

        return $this->formatter->formatPretty($this);
    }

    public function __toString()
    {
        return $this->format();
    }
}