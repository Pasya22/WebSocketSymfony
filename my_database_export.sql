--
-- PostgreSQL database dump
--

-- Dumped from database version 14.5
-- Dumped by pg_dump version 14.5

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

--
-- Name: notify_change(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.notify_change() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    PERFORM pg_notify('data_change', row_to_json(NEW)::text);
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.notify_change() OWNER TO postgres;

--
-- Name: notify_message_update(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.notify_message_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  -- Mengirim notifikasi dengan payload berupa JSON dari data yang baru di-insert
  PERFORM pg_notify('message_updates', json_build_object(
    'idassy', NEW.idassy,
    'zvalue', NEW.zvalue,
    'xvalue', NEW.xvalue,
    'username', NEW.username,
    'datetime', NEW.datetime,
    'status', NEW.status
  )::text);
  RETURN NEW;
END;
$$;


ALTER FUNCTION public.notify_message_update() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: data_realtime; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.data_realtime (
    idassy integer NOT NULL,
    zvalue numeric(8,2) NOT NULL,
    xvalue numeric(8,2) NOT NULL,
    username character varying(255) NOT NULL,
    datetime date NOT NULL,
    status character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.data_realtime OWNER TO postgres;

--
-- Name: data_realtime_idassy_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.data_realtime_idassy_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.data_realtime_idassy_seq OWNER TO postgres;

--
-- Name: data_realtime_idassy_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.data_realtime_idassy_seq OWNED BY public.data_realtime.idassy;


--
-- Name: data_setting_idassy_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.data_setting_idassy_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.data_setting_idassy_seq OWNER TO postgres;

--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO postgres;

--
-- Name: data_realtime idassy; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.data_realtime ALTER COLUMN idassy SET DEFAULT nextval('public.data_realtime_idassy_seq'::regclass);


--
-- Data for Name: data_realtime; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.data_realtime (idassy, zvalue, xvalue, username, datetime, status, created_at, updated_at) FROM stdin;
8	88888.00	7878.00	YUYU	2024-09-14	iiii	2024-09-17 08:28:13.288489	2024-09-14 17:27:55.164469
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20240913031821	2024-09-13 08:05:53	10
\.


--
-- Name: data_realtime_idassy_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.data_realtime_idassy_seq', 2, true);


--
-- Name: data_setting_idassy_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.data_setting_idassy_seq', 1, false);


--
-- Name: data_realtime data_realtime_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.data_realtime
    ADD CONSTRAINT data_realtime_pkey PRIMARY KEY (idassy);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: data_realtime data_change_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER data_change_trigger AFTER UPDATE ON public.data_realtime FOR EACH ROW EXECUTE FUNCTION public.notify_change();


--
-- Name: data_realtime message_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER message_update_trigger AFTER INSERT OR UPDATE ON public.data_realtime FOR EACH ROW EXECUTE FUNCTION public.notify_message_update();


--
-- PostgreSQL database dump complete
--

