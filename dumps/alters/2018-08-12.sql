ALTER TABLE public.scores ADD dataplan smallint default (0)::smallint not null;
ALTER TABLE public.scores ADD overal_score double precision DEFAULT (0)::double precision NULL;
ALTER TABLE public.scores ALTER COLUMN wb_pgld_speed_score TYPE double precision USING wb_pgld_speed_score::double precision;
ALTER TABLE public.scores ALTER COLUMN wb_pgld_speed_score SET DEFAULT (0)::double precision;
ALTER TABLE public.scores ALTER COLUMN wb_pgld_success_score TYPE double precision USING wb_pgld_success_score::double precision;
ALTER TABLE public.scores ALTER COLUMN wb_pgld_success_score SET DEFAULT (0)::double precision;
ALTER TABLE public.scores ALTER COLUMN video_pgld_speed_score TYPE double precision USING video_pgld_speed_score::double precision;
ALTER TABLE public.scores ALTER COLUMN video_pgld_speed_score SET DEFAULT (0)::double precision;
ALTER TABLE public.scores ALTER COLUMN video_pgld_success_score TYPE double precision USING video_pgld_success_score::double precision;
ALTER TABLE public.scores ALTER COLUMN video_pgld_success_score SET DEFAULT (0)::double precision;

ALTER TABLE public.scores ADD pre_paid_light_score double precision DEFAULT (0)::double precision;
ALTER TABLE public.scores ADD pre_paid_medium_score double precision DEFAULT (0)::double precision;
ALTER TABLE public.scores ADD pre_paid_heavy_score double precision DEFAULT (0)::double precision;
ALTER TABLE public.scores ADD post_paid_light_score double precision DEFAULT (0)::double precision;
ALTER TABLE public.scores ADD post_paid_medium_score double precision DEFAULT (0)::double precision;
ALTER TABLE public.scores ADD post_paid_heavy_score double precision DEFAULT (0)::double precision;
ALTER TABLE public.scores DROP dataplan;

update public.scores
set wb_pgld_speed_score = floor(random() * 1000) / 100,
  wb_pgld_success_score = floor(random() * 1000) / 100,
  video_pgld_speed_score = floor(random() * 1000) / 100,
  video_pgld_success_score = floor(random() * 1000) / 100,
  overall_score = floor(random() * 1000) / 100,
  pre_paid_light_score = floor(random() * 1000) / 100,
  pre_paid_medium_score = floor(random() * 1000) / 100,
  pre_paid_heavy_score = floor(random() * 1000) / 100,
  post_paid_light_score = floor(random() * 1000) / 100,
  post_paid_medium_score = floor(random() * 1000) / 100,
  post_paid_heavy_score = floor(random() * 1000) / 100
;