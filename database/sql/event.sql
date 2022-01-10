select e.*
, case
    when em.status = 0 then '参加'
    when em.status = 1 then 'キャンセル待ち'
    else '不参加'
  end
from event e
left join event_user em
on e.id = em.event_id
left join 
(
    select event_id
    , sum(1 + ifnull((select count(*) from event_user_companion where user_id = em.user_id), 0)) cnt
    from event_user em
    group by event_id
) m
on e.id = m.event_id


----------

