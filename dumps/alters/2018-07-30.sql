ALTER TABLE public.scores ADD wb_pgld_speed_score char(3) NULL;
ALTER TABLE public.scores ADD wb_pgld_success_score char(3) NULL;
ALTER TABLE public.scores ADD video_pgld_speed_score char(3) NULL;
ALTER TABLE public.scores ADD video_pgld_success_score char(3) NULL;

update public.scores
set wb_pgld_speed_score = floor(random() * 10),
  wb_pgld_success_score = floor(random() * 10),
  video_pgld_speed_score = floor(random() * 10),
  video_pgld_success_score = floor(random() * 10),
  sc
;