# Package HTMx for Concrete CMS

Concrete CMS integration for [htmx](https://htmx.org/).

## Usage

### Add necessary assets

To work successfully, you need to add htmx.js. In the case of the block controller, this is done in the `registerViewAssets` method, in the SinglePage controller in the `on_start` or `view` method.

You need to add the following directive:

```php
$this->requireAsset('javascript', 'htmx');
```

An example for a block controller:

```php
/**
 * Method for adding assets.
 */
public function registerViewAssets($outputContent = '')
{
	$this->requireAsset('javascript', 'htmx');
}
```

### Request

You can resolve an instance of the `HtmxRequest` for reading the htmx-specific [request headers](https://htmx.org/reference/#request_headers).

```php
use HTMx\Http\HtmxRequest;

public function action()
{
	$request = HtmxRequest::getInstance();

    // always true if the request is performed by Htmx
    $request->isHtmxRequest();
    // indicates that the request is via an element using hx-boost
    $request->isBoosted();
    // the current URL of the browser
    $request->getCurrentUrl();
    // true if the request is for history restoration after a miss in the local history cache
    $request->isHistoryRestoreRequest()
    // the user response to an hx-prompt
    $request->getPromptResponse();
    // 	the id of the target element if it exists
    $request->getTarget();
    // the name of the triggered element if it exists
    $request->getTriggerName();
    // the id of the triggered element if it exists
    $request->getTriggerId();
}
```

### Response

- `HtmxResponseClientRedirect`

htmx can trigger a client side redirect when it receives a response with the `HX-Redirect` [header](https://htmx.org/reference/#response_headers). The `HtmxResponseClientRedirect` makes it easy to trigger such redirects.

```php
use HTMx\Http\HtmxResponseClientRedirect;

public function action(): HtmxResponseClientRedirect
{
    return new HtmxResponseClientRedirect('/somewhere-else');
}
```

- `HtmxResponseClientRefresh`

htmx will trigger a page reload when it receives a response with the `HX-Refresh` [header](https://htmx.org/reference/#response_headers). `HtmxResponseClientRefresh` is a custom response class that allows you to send such a response. It takes no arguments, since htmx ignores any content.

```php
use HTMx\Http\HtmxResponseClientRefresh;

public function action(): HtmxResponseClientRefresh
{
    return new HtmxResponseClientRefresh();
}
```

- `HtmxResponseStopPolling`

When using a [polling trigger](https://htmx.org/docs/#polling), htmx will stop polling when it encounters a response with the special HTTP status code 286. `HtmxResponseStopPolling` is a custom response class with that status code.

```php
use HTMx\Http\HtmxResponseStopPolling;

public function action(): HtmxResponseStopPolling
{
    return new HtmxResponseStopPolling();
}
```

For all the remaining [available headers](https://htmx.org/reference/#response_headers) you can use the `HtmxResponse` class.

```php
use HTMx\Http\HtmxResponse;

public function action(): HtmxResponse
{
    return (new HtmxResponse())
        ->location($location) // Allows you to do a client-side redirect that does not do a full page reload (also supports arrays)
        ->pushUrl($url) // pushes a new url into the history stack
        ->replaceUrl($url) // replaces the current URL in the location bar
        ->reswap($option) // Allows you to specify how the response will be swapped
        ->retarget($selector); // A CSS selector that updates the target of the content update to a different element on the page
}
```

Additionally, you can trigger [client-side events](https://htmx.org/headers/hx-trigger/) using the `addTrigger` methods.

```php
use HTMx\Http\HtmxResponse;

public function action(): HtmxResponse
{
    return (new HtmxResponse())
        ->addTrigger("myEvent")
        ->addTriggerAfterSettle("myEventAfterSettle")
        ->addTriggerAfterSwap("myEventAfterSwap");
});
```

If you want to pass details along with the event you can use the second argument to send a body. It supports strings or arrays.

```php
use HTMx\Http\HtmxResponse;

public function action(): HtmxResponse
{
    return (new HtmxResponse()
        ->addTrigger("showMessage", "Here Is A Message")
        ->addTriggerAfterSettle("showAnotherMessage", [
            "level" => "info",
            "message" => "Here Is A Message"
        ]);
});
```

You can call those methods multiple times if you want to trigger multiple events.

```php
use HTMx\Http\HtmxResponse;

public function action(): HtmxResponse
{
    return (new HtmxResponse())
        ->addTrigger("event1", "A Message")
        ->addTrigger("event2", "Another message");
});
```

### Render Fragments

This library also provides a basic service to render [fragments](https://htmx.org/essays/template-fragments/) from elements.

```php
use HTMx\Http\HtmxResponse;

public function action(): HtmxResponse
	$request = HtmxRequest::getInstance();
	return (new HtmxResponse())
		->renderFragment('forms/result', [
			'request' => $request->request()
		], 'htmx_example');
});
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.