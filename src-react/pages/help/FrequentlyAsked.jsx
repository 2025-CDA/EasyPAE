import React from "react";
import Container from "../../components/ui/Container";
export function FrequentlyAsked({color, description}) {
  
  return <Container className={`bg-[${color}] rounded shadow snap-start max-w-[250px]`}>
                        <p>{description} </p>
                        </Container>;
}
  