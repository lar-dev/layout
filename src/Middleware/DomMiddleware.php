<?php

namespace Lar\Layout\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ViewErrorBag;
use Lar\Layout\BladeDirectives;
use Lar\Layout\Core\Dom;
use Lar\Layout\Core\LConfigs;
use Lar\Layout\Respond;
use Lar\LJS\LJS;
use voku\helper\HtmlDomParser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class DomMiddleware
 *
 * @package Lar\Layout\Middleware
 */
class DomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        if ($response->isRedirection()) {

            session()->flash("respond", Respond::glob()->toJson());

            return $response;
        }

        if ($request->ajax() && !$request->pjax()) {

            return $response;
        }

        if (!$request->isMethod("get")) {

            return $response;
        }

        $this->setUriHeader($response, $request)
            ->setErrorsToasts()
            ->setGlobalRespond()
            ->setFlashRespond()
            ->setContent($request, $response);

        $response->withHeaders(LConfigs::$list);


        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return $this
     * @throws \Exception
     */
    protected function setContent(Request $request, Response $response)
    {
        $js = '';

        if (!$response->exception) {

            $content = Dom::buildCollect();

            $js = \LJS::render();

            if (!$request->ajax()) {

                $content = str_replace(
                    "<script data-exec-on-popstate></script>",
                    "<script data-exec-on-popstate>".$js."</script>",
                    $content
                );
            }

            $response->setContent($content);
        }

        if ($request->pjax() && $request->header('X-PJAX-CONTAINER')) {

            $html = HtmlDomParser::str_get_html($response->getContent());

            $content = $html->find($request->header('X-PJAX-CONTAINER'), 0)->innerText();

            $ljs = new LJS("live");

            $respond = new Respond();

            $this->createAttributeWatcher($respond, $html)
                ->createTagWatcher($respond, $html);

            $ljs->line("ljs.exec(".$respond->toJson().")");

            $js = $ljs->render().$js;

            if (!empty($js)) {

                if (strpos($content, "<script data-exec-on-popstate></script>") !== false) {

                    $content = str_replace(
                        "<script data-exec-on-popstate></script>",
                        "<script compile data-exec-on-popstate>".$js."</script>",
                        $content
                    );
                }

                else {

                    $content .= "<script compile data-exec-on-popstate>".$js."</script>";
                }
            }

            $response->setContent($content);
        }

        return $this;
    }

    /**
     * @param Respond $respond
     * @param HtmlDomParser $html
     * @return $this
     */
    protected function createTagWatcher(Respond $respond, HtmlDomParser $html)
    {
        foreach (BladeDirectives::$_lives as $life) {

            $respond->jq("[data-live='{$life}']")->html(
                $html->find("[data-live='{$life}']", 0)->innerText()
            );
        }

        $respond->dispatch_event("ljs:on_watch")
            ->title($html->find('title', 0)->innerText());

        return $this;
    }

    /**
     * @param Respond $respond
     * @param HtmlDomParser $html
     * @return $this
     */
    protected function createAttributeWatcher(Respond $respond, HtmlDomParser $html)
    {
        $change_class = [];

        foreach (BladeDirectives::$_attr_watches as $attr_watch) {

            $id = "[data-attr-watch='{$attr_watch[0]}']";

            $attributes = isset($attr_watch[1]) ? (is_string($attr_watch[1]) ? [$attr_watch[1]] : $attr_watch[1]) : false;

            if ((is_array($attributes) && !count($attributes)) || !is_array($attributes)) {

                $attributes = $html->find($id, 0)->getAllAttributes();
            }

            else {

                $ff = $html->find($id, 0);

                foreach ($attributes as $key => $attribute) {

                    unset($attributes[$key]);

                    $attributes[$attribute] = $ff->getAttribute($attribute);
                }
            }

            $change_class[$id] = $attributes;
        }

        $respond->jq()->manyAttributes($change_class);
        $respond->dispatch_event("ljs:on_attr_watch");

        return $this;
    }

    /**
     * @return $this
     */
    protected function setErrorsToasts()
    {
        if (config('layout.toast_errors', true) && session()->has('errors')) {

            /** @var ViewErrorBag $bags */
            $bags = session('errors');

            $messages = $bags->getBag('default')->all();

            foreach ($messages as $message) {

                Respond::glob()->toast_error($message);
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function setFlashRespond()
    {
        if (session()->has('respond')) {

            $ljs = new LJS("Flash");

            $ljs->line("ljs.exec(".session('respond').")");
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function setGlobalRespond () {

        if (Respond::glob()->count()) {

            $ljs = new LJS("Global");

            $ljs->line("ljs.exec(".Respond::glob()->toJson().")");
        }

        return $this;
    }

    /**
     * @param Response|RedirectResponse $response
     * @param Request $request
     * @return DomMiddleware
     */
    protected function setUriHeader($response, Request $request)
    {
        $response->header('X-PJAX-URL', $request->getRequestUri());

        return $this;
    }
}
