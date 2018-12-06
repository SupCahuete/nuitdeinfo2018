<?php

if (! empty($greeting)) {
  echo $greeting, "\n\n";
} else {
  echo $level == 'error' ? trans('notif.email.whoops')  : trans('notif.email.hello'), "\n\n";
}

if (! empty($introLines)) {
  echo implode("\n", $introLines), "\n\n";
}

if (isset($actionText)) {
  echo "{$actionText}: {$actionUrl}", "\n\n";
}

if (! empty($outroLines)) {
  echo implode("\n", $outroLines), "\n\n";
}

echo trans("notif.email.salutation", ['sep' => '\n', 'name' => config('app.name')]), "\n\n";

echo config('app.name') . ' ' . trans('notif.email.copyright');

