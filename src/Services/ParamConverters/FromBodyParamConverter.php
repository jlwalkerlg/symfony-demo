<?php

namespace App\Services\ParamConverters;

use App\Exception\RequestValidationException;
use Psr\Container\ContainerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FromBodyParamConverter implements ParamConverterInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $formTypeName = $configuration->getOptions()['formTypeName'];
        $className = $configuration->getClass();
        $data = new $className;

        /** @var FormInterface */
        $form = $this->container->get('form.factory')->create($formTypeName, $data);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $request->attributes->set($configuration->getName(), $form->getData());
            return true;
        }

        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()] = $error->getMessage();
        }

        throw new RequestValidationException($errors);
    }

    public function supports(ParamConverter $configuration)
    {
        $options = $configuration->getOptions();

        if (!array_key_exists('formTypeName', $options)) return false;

        $formTypeName = $options['formTypeName'];

        return class_exists($formTypeName) && in_array(AbstractType::class, class_parents($formTypeName));
    }
}
