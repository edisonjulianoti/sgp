<?php
/**
 * AgendamentoCalendarForm Form
 * @author  <your name here>
 */
class AgendamentoCalendarFormView extends TPage
{
    private $fc;

    /**
     * Page constructor
     */
    public function __construct($param = null)
    {
        parent::__construct();

        $this->fc = new TFullCalendar(date('Y-m-d'), 'month');
        $this->fc->enableDays([0,1,2,3,4,5,6]);
        $this->fc->setReloadAction(new TAction(array($this, 'getEvents'), $param));
        $this->fc->setDayClickAction(new TAction(array('AgendamentoCalendarForm', 'onStartEdit')));
        $this->fc->setEventClickAction(new TAction(array('AgendamentoCalendarForm', 'onEdit')));
        $this->fc->setEventUpdateAction(new TAction(array('AgendamentoCalendarForm', 'onUpdateEvent')));
        $this->fc->setCurrentView('agendaWeek');
        $this->fc->setTimeRange('00:00', '23:00');
        $this->fc->enablePopover('Agengamento', " {titulo} -  {descricao} ");
        $this->fc->setOption('slotTime', "00:30:00");
        $this->fc->setOption('slotDuration', "00:30:00");
        $this->fc->setOption('slotLabelInterval', 30);

        parent::add( $this->fc );
    }

    /**
     * Output events as an json
     */
    public static function getEvents($param=NULL)
    {
        $return = array();
        try
        {
            TTransaction::open('bd_sgp');

            $criteria = new TCriteria(); 

            $criteria->add(new TFilter('data_inicio', '<=', substr($param['end'], 0, 10).' 23:59:59'));
            $criteria->add(new TFilter('data_fim', '>=', substr($param['start'], 0, 10).' 00:00:00'));

            $filterVar = TSession::getValue("userid");
            $criteria->add(new TFilter('system_users_id', '=', $filterVar)); 

            $events = Agendamento::getObjects($criteria);

            if ($events)
            {
                foreach ($events as $event)
                {
                    $event_array = $event->toArray();
                    $event_array['start'] = str_replace( ' ', 'T', $event_array['data_inicio']);
                    $event_array['end'] = str_replace( ' ', 'T', $event_array['data_fim']);
                    $event_array['id'] = $event->id;
                    $event_array['color'] = $event->render("{relevancia->cor}");
                    $event_array['title'] = TFullCalendar::renderPopover($event->render(" {titulo} "), $event->render("Agengamento"), $event->render(" {titulo} -  {descricao} "));

                    $return[] = $event_array;
                }
            }
            TTransaction::close();
            echo json_encode($return);
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    /**
     * Reconfigure the callendar
     */
    public function onReload($param = null)
    {
        if (isset($param['view']))
        {
            $this->fc->setCurrentView($param['view']);
        }

        if (isset($param['date']))
        {
            $this->fc->setCurrentDate($param['date']);
        }
    }

}

