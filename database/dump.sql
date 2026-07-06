--
-- PostgreSQL database dump
--

\restrict yK5Y8BWlJ9aZ4jUaVgq5Dp3scyFcu74vayDtuDlLCpZNJxdvwBva3DNDyd5dQTG

-- Dumped from database version 15.18 (Homebrew)
-- Dumped by pg_dump version 15.18 (Homebrew)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration bigint NOT NULL
);


ALTER TABLE public.cache OWNER TO "haris-work";

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration bigint NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO "haris-work";

--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection character varying(255) NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO "haris-work";

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: haris-work
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO "haris-work";

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: haris-work
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO "haris-work";

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO "haris-work";

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: haris-work
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jobs_id_seq OWNER TO "haris-work";

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: haris-work
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO "haris-work";

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: haris-work
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO "haris-work";

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: haris-work
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO "haris-work";

--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name text NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO "haris-work";

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: haris-work
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO "haris-work";

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: haris-work
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO "haris-work";

--
-- Name: table1; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.table1 (
    id integer NOT NULL,
    title character varying(255) NOT NULL,
    content text NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.table1 OWNER TO "haris-work";

--
-- Name: table1_id_seq; Type: SEQUENCE; Schema: public; Owner: haris-work
--

CREATE SEQUENCE public.table1_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.table1_id_seq OWNER TO "haris-work";

--
-- Name: table1_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: haris-work
--

ALTER SEQUENCE public.table1_id_seq OWNED BY public.table1.id;


--
-- Name: table2; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.table2 (
    id integer NOT NULL,
    content_id integer NOT NULL,
    content text NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.table2 OWNER TO "haris-work";

--
-- Name: table2_id_seq; Type: SEQUENCE; Schema: public; Owner: haris-work
--

CREATE SEQUENCE public.table2_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.table2_id_seq OWNER TO "haris-work";

--
-- Name: table2_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: haris-work
--

ALTER SEQUENCE public.table2_id_seq OWNED BY public.table2.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: haris-work
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO "haris-work";

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: haris-work
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO "haris-work";

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: haris-work
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: table1 id; Type: DEFAULT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.table1 ALTER COLUMN id SET DEFAULT nextval('public.table1_id_seq'::regclass);


--
-- Name: table2 id; Type: DEFAULT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.table2 ALTER COLUMN id SET DEFAULT nextval('public.table2_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_06_30_083336_create_posts_table	2
5	2026_07_03_013521_create_personal_access_tokens_table	2
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: personal_access_tokens; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.personal_access_tokens (id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, expires_at, created_at, updated_at) FROM stdin;
1	App\\Models\\User	1	auth_token	ff65fce049901e49b5845f57c86bb8556ad443d49c453c6a00cbfc13b09791ca	["*"]	\N	\N	2026-07-03 03:02:42	2026-07-03 03:02:42
2	App\\Models\\User	1	auth_token	c7576372a4a4094c0627e441248cc5eb27219a75868ea3b21f6e707429c779d1	["*"]	2026-07-03 03:06:02	\N	2026-07-03 03:04:30	2026-07-03 03:06:02
5	App\\Models\\User	2	auth_token	41d3e4287c7a91d447b01cede884a1755eed4ee22699206bcf9af37b077f8d55	["*"]	\N	\N	2026-07-03 03:11:18	2026-07-03 03:11:18
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
\.


--
-- Data for Name: table1; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.table1 (id, title, content, created_at, updated_at) FROM stdin;
1	title1	content1	2026-06-30 08:46:39	2026-06-30 08:46:39
2	title2	content2	2026-06-30 08:48:12	2026-06-30 08:48:12
3	title30	content30	2026-07-01 09:23:35	2026-07-02 07:52:54
4	title4	content4	2026-07-02 04:14:43	2026-07-02 07:52:54
6	title11	content11	2026-07-02 07:33:58	2026-07-02 07:52:54
7	title9	title9	2026-07-02 07:53:19	2026-07-02 07:53:19
9	title10	content10	2026-07-03 03:06:02	2026-07-03 03:06:02
10	title120	content120	2026-07-03 03:10:17	2026-07-03 03:10:26
\.


--
-- Data for Name: table2; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.table2 (id, content_id, content, created_at, updated_at) FROM stdin;
1	1	content1	2026-06-30 16:39:24.796083	2026-06-30 16:39:24.796083
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: haris-work
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
1	haris	a.haris@blueteam.jp	\N	$2y$12$9Des3YPbCfBYPXGwbo0OE.D.fFHJQ1H5S4hzN1Y8CJcOTX5XBO6Va	\N	2026-07-03 03:02:42	2026-07-03 03:02:42
2	test	test@test.com	\N	$2y$12$VmGYhAXMJnXdxBY.7biHEucTDzb/ljwG2mibIZ/VS2PxSB6WLcvGm	\N	2026-07-03 03:10:57	2026-07-03 03:10:57
\.


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: haris-work
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: haris-work
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: haris-work
--

SELECT pg_catalog.setval('public.migrations_id_seq', 5, true);


--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: haris-work
--

SELECT pg_catalog.setval('public.personal_access_tokens_id_seq', 5, true);


--
-- Name: table1_id_seq; Type: SEQUENCE SET; Schema: public; Owner: haris-work
--

SELECT pg_catalog.setval('public.table1_id_seq', 10, true);


--
-- Name: table2_id_seq; Type: SEQUENCE SET; Schema: public; Owner: haris-work
--

SELECT pg_catalog.setval('public.table2_id_seq', 1, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: haris-work
--

SELECT pg_catalog.setval('public.users_id_seq', 2, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: table1 table1_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.table1
    ADD CONSTRAINT table1_pkey PRIMARY KEY (id);


--
-- Name: table1 table1_title_unique; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.table1
    ADD CONSTRAINT table1_title_unique UNIQUE (title);


--
-- Name: table2 table2_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.table2
    ADD CONSTRAINT table2_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: haris-work
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: haris-work
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: haris-work
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: failed_jobs_connection_queue_failed_at_index; Type: INDEX; Schema: public; Owner: haris-work
--

CREATE INDEX failed_jobs_connection_queue_failed_at_index ON public.failed_jobs USING btree (connection, queue, failed_at);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: haris-work
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: personal_access_tokens_expires_at_index; Type: INDEX; Schema: public; Owner: haris-work
--

CREATE INDEX personal_access_tokens_expires_at_index ON public.personal_access_tokens USING btree (expires_at);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: haris-work
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: haris-work
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: haris-work
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: DEFAULT PRIVILEGES FOR SEQUENCES; Type: DEFAULT ACL; Schema: public; Owner: laravel_user
--

ALTER DEFAULT PRIVILEGES FOR ROLE laravel_user IN SCHEMA public GRANT ALL ON SEQUENCES  TO laravel_user;


--
-- Name: DEFAULT PRIVILEGES FOR TABLES; Type: DEFAULT ACL; Schema: public; Owner: laravel_user
--

ALTER DEFAULT PRIVILEGES FOR ROLE laravel_user IN SCHEMA public GRANT ALL ON TABLES  TO laravel_user;


--
-- PostgreSQL database dump complete
--

\unrestrict yK5Y8BWlJ9aZ4jUaVgq5Dp3scyFcu74vayDtuDlLCpZNJxdvwBva3DNDyd5dQTG

