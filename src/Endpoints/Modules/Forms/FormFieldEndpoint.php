<?php

namespace Ominity\Api\Endpoints\Modules\Forms;


use Ominity\Api\Resources\LazyCollection;
use Ominity\Api\Endpoints\CollectionEndpointAbstract;
use Ominity\Api\Resources\Modules\Forms\Form;
use Ominity\Api\Resources\Modules\Forms\FormField;
use Ominity\Api\Resources\Modules\Forms\FormFieldCollection;

class FormFieldEndpoint extends CollectionEndpointAbstract
{
    /**
     * @var string
     */
    protected $resourcePath = "modules/forms/{formId}/fields";

    /**
     * @inheritDoc
     */
    protected function getResourceCollectionObject($count, $_links)
    {
        return new FormFieldCollection($this->client, $count, $_links);
    }

    /**
     * @inheritDoc
     */
    protected function getResourceObject()
    {
        return new FormField($this->client);
    }

    /**
     * List the fields for a specific Form.
     *
     * @param Form $form
     * @param array $parameters
     * @return FormFieldCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listFor(Form $form, array $parameters = [])
    {
        return $this->listForId($form->id, $parameters);
    }

    /**
     * List the fields for a specific Form ID.
     *
     * @param string $formId
     * @param array $parameters
     * @return FormFieldCollection
     *
     * @throws \Ominity\Api\Exceptions\ApiException
     */
    public function listForId(int $formId, array $parameters = [])
    {
        $this->setPathVariables(['formId' => $formId]);

        return parent::rest_list(null, null, $parameters);
    }

    /**
     * Create an iterator for iterating over form fields for the given form retrieved from Ominity.
     *
     * @param Form $form
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorFor(Form $form, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        return $this->iteratorForId($form->id, $parameters, $iterateBackwards);
    }

    /**
     * Create an iterator for iterating over form fields for the given form id retrieved from Ominity.
     *
     * @param string $formId
     * @param array $parameters
     * @param bool $iterateBackwards Set to true for reverse order iteration (default is false).
     *
     * @return LazyCollection
     */
    public function iteratorForId(int $formId, array $parameters = [], bool $iterateBackwards = false): LazyCollection
    {
        $this->setPathVariables(['formId' => $formId]);

        return $this->rest_iterator(null, null, $parameters, $iterateBackwards);
    }
}