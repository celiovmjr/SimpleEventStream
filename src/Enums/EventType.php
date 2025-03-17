<?php

namespace SimpleEventStream\Application\Enums;

enum EventType: string
{
    case CONNECT = 'connect';
    case OPEN = 'open';
    case CLOSE = 'close';
    case MESSAGE = 'message';
    case ERROR = 'error';
    case RECONNECT = 'reconnect';
    case PONG = 'pong';
    case USER_JOIN = 'user_join';
    case USER_LEAVE = 'user_leave';
    case TYPING = 'typing';
    case STOP_TYPING = 'stop_typing';
    case UPDATE = 'update';
    case NOTIFY = 'notify';
    case AUTHENTICATED = 'authenticated';
    case AUTH_ERROR = 'auth_error';
    case PROGRESS = 'progress';
    case ACKNOWLEDGE = 'acknowledge';
    case CUSTOM = 'custom_event';
}
