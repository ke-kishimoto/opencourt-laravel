イベント詳細
イベント：{{ $event->title }}
日付：{{ $event->event_date }}
開始時刻：{{ $event->start_time }}
場所：{{ $event->place }}
人数上限：{{ $event->limit_number}}人
参加予定：{{ $event->participants_number}}人
参加費：
{{ $category_name1 }}：{{$event->price1}}
{{ $category_name2 }}：{{$event->price2}}
{{ $category_name3 }}：{{$event->price3}}
詳細：{{ $event->description }}