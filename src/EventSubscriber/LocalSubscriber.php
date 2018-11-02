<?php

//https://gist.github.com/kunicmarko20/02a42c76f638322d58b1def7d2e770d7

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LocalSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;
    private $defaultLocale;
    private $locales;

    public function __construct(UrlGeneratorInterface $urlGenerator, string $locales, string $defaultLocale)
    {
        $this->urlGenerator = $urlGenerator;

        $this->locales = explode('|', trim($locales));
        if (empty($this->locales)) {
            throw new \UnexpectedValueException('The list of supported locales must not be empty.');
        }

        $this->defaultLocale = $defaultLocale;
        if (!\in_array($this->defaultLocale, $this->locales, true)) {
            throw new \UnexpectedValueException(sprintf('The default locale ("%s") must be one of "%s".', $this->defaultLocale, $locales));
        }

        // Add the default locale at the first position of the array,
        // because Symfony\HttpFoundation\Request::getPreferredLanguage
        // returns the first element when no an appropriate language is found
        array_unshift($this->locales, $this->defaultLocale);
        $this->locales = array_unique($this->locales);
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        $res = $this->checkLocale($request->getPathInfo(), $request->headers->get('referer'));

        //dump($res); die('ok');


        // Если в $request->getPathInfo() есть локаль, поддерживаемая приложением, ничего дальше не делаем
        if ($this->checkLocale($request->getPathInfo())) {
            return;
        }




        // Ignore sub-requests and all URLs but the homepage
        if (!$event->isMasterRequest() || '/' !== $request->getPathInfo()) {
            return;
        }

        // Ignore requests from referrers with the same HTTP host in order to prevent
        // changing language for users who possibly already selected it for this application.
        if (0 === mb_stripos($request->headers->get('referer'), $request->getSchemeAndHttpHost())) {
            return;
        }



        /* 1. Функция Request::getLanguages получает языки браузера Accept-Language, трансформирует ru-RU в ru_RU, возвращаем массив с языками
         * 2. Функция Request::getPreferredLanguage
         *    1) получает массив языков от Request::getLanguages, сохраняет его в $preferredLanguages
         *    2) трансформирует $preferredLanguages, добавляет в него первую часть составных языков (ru из ru_RU), получается массив $extendedPreferredLanguages
         *    3) получает пересечение массивов $extendedPreferredLanguages и $locales (поддерживаемых языков приложения), сохраняет только значения из получившегося массива в $preferredLanguages
         *    4) возвращает первый элемент массива $preferredLanguages в качестве $preferredLanguage
        */
        $preferredLanguage = $request->getPreferredLanguage($this->locales);

        //if ($preferredLanguage !== $this->defaultLocale) {
            $response = new RedirectResponse($this->urlGenerator->generate('homepage', ['_locale' => $preferredLanguage]));
            $event->setResponse($response);
        //}
    }

    /*
     * Проверяем текущий адрес, на который идет запрос. Если в нем есть язык из поддерживаемых языков приложения, возвращаем false. Если нет:
     * проверяем реферер. Если в нем есть язык из поддерживаемых языков приложения, возвращаем этот язык. Если нет:
     * возвращаем язык приложения по-умолчанию.
     */
    private function checkLocale2($route, $referer)
    {
        foreach($this->locales as $locale){
            if(preg_match_all("/\/$locale\//", $route))
                return false;
            if(preg_match_all("/\/$locale\//", $referer))
                return $locale;
        }
        return $this->defaultLocale;
    }


    public function checkLocale($path)
    {
        foreach ($this->locales as $locale) {
            if (preg_match_all("/\/$locale\//", $path))
                return true;
        }

        return false;
    }

    public function checkReferer($referer)
    {
        foreach ($this->locales as $locale) {
            if (preg_match_all("/\/$locale\//", $referer))
                return $locale;
        }

        return false;
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            // must be registered before (i.e. with a higher priority than) the default Locale listener
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        );
    }
}