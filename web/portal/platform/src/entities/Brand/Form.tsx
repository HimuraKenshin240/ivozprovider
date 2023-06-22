import useFkChoices from '@irontec/ivoz-ui/entities/data/useFkChoices';
import {
  EntityFormProps,
  FieldsetGroups,
} from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import { Form as DefaultEntityForm } from '@irontec/ivoz-ui/entities/DefaultEntityBehavior/Form';
import _ from '@irontec/ivoz-ui/services/translations/translate';

import { foreignKeyGetter } from './ForeignKeyGetter';

const Form = (props: EntityFormProps): JSX.Element => {
  const { entityService, row, match } = props;
  const edit = props.edit || false;

  const fkChoices = useFkChoices({
    foreignKeyGetter,
    entityService,
    row,
    match,
  });

  const groups: Array<FieldsetGroups | false> = [
    {
      legend: _('Basic Configuration'),
      fields: [
        'name',
        edit && 'invoice.nif',
        'proxyTrunks',
        'features',
        edit && 'logo',
        'maxCalls',
      ],
    },
    {
      legend: _('Locales'),
      fields: ['defaultTimezone', 'language', 'currency'],
    },
    edit && {
      legend: _('SIP domain', { count: 1 }),
      fields: ['domainUsers'],
    },
    edit && {
      legend: _('Invoice Data'),
      fields: [
        'invoice.postalAddress',
        'invoice.postalCode',
        'invoice.town',
        'invoice.province',
        'invoice.country',
        'invoice.registryData',
      ],
    },
  ];

  return <DefaultEntityForm {...props} fkChoices={fkChoices} groups={groups} />;
};

export default Form;
