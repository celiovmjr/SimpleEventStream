# SimpleEventStream

The `EventStream` class enables the implementation of **Server-Sent Events (SSE)** for real-time communication between the server and the client. With this class, you can send various types of events such as error messages, notifications, progress updates, and more, using the SSE protocol.

## Features

- **Start and close the event stream**.
- **Emit custom events** like error messages, notifications, updates, and progress.
- **Simulate events** such as user joining, leaving, typing, and stopping typing.
- Full support for **Server-Sent Events** with appropriate headers.

## Installation
```bash
composer require celiovmjr/simpleeventstream
```

## Example Usage

Below is a basic example of how to use the `EventStream` class:

```php
use SimpleEventStream\Application\EventStream;

// Create an instance of EventStream
$eventStream = new EventStream();

// Start the event stream
$eventStream->start();

// Send a notification
$eventStream->sendNotification("New event available!");

// Send a progress event
$eventStream->sendProgress(45.5);

// Send a custom update
$eventStream->sendUpdate(['status' => 'in progress']);

// Send a custom event
$eventStream->customEvent(['customData' => 'value']);

// Close the event stream
$eventStream->close();
```

## Methods

### `start()`
Starts the event stream and sends a "connection opened" message.

### `emit(StreamMessage $message)`
Emits a message to the stream. Requires the stream to be started.

### `close()`
Closes the event stream and sends a "connection closed" message.

### `sendError(string $error)`
Sends an error message to the client.

### `sendNotification(string $notification)`
Sends a custom notification to the client.

### `userJoin(string $username)`
Simulates a user joining the system.

### `userLeave(string $username)`
Simulates a user leaving the system.

### `typing(string $username)`
Simulates the typing event for a user.

### `stopTyping(string $username)`
Simulates the event when a user stops typing.

### `sendUpdate(array $data)`
Sends an update event with custom data.

### `sendProgress(float $percentage)`
Sends a progress event with a percentage (0 to 100).

### `acknowledge(string $message)`
Sends an acknowledgment message to the client.

### `customEvent(array $data)`
Sends a custom event with user-provided data.

## Notes

- The `EventStream` class uses **output buffering** in PHP, utilizing `ob_implicit_flush()` and `ob_end_flush()` to ensure data is sent to the client in real-time.
- Communication is done through the **Server-Sent Events (SSE)** protocol, which is one-way and ideal for sending continuous updates from the server to the client.
- Ensure your web server is configured to support SSE.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.