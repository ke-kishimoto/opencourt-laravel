select e.*
, case
    when em.status = 0 then '参加'
    when em.status = 1 then 'キャンセル待ち'
    else '不参加'
  end
from event e
left join event_member em
on e.id = em.event_id
left join 
(
    select event_id
    , sum(1 + ifnull((select count(*) from event_member_companion where member_id = em.member_id), 0)) cnt
    from event_member em
    group by event_id
) m
on e.id = m.event_id


----------

